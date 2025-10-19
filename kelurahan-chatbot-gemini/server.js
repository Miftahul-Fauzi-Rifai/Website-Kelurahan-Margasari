// server.js
// Express server untuk chatbot dengan Gemini API + data lokal (RAG sederhana)

require('dotenv').config(); // Load environment variables

const express = require('express');
const axios = require('axios');
const multer = require('multer');
const fs = require('fs');

const upload = multer({ dest: process.env.UPLOAD_DIR || 'uploads/' });
const app = express();
const PORT = process.env.PORT || 3000;

// ======== CORS Configuration untuk Laravel Integration =========
app.use((req, res, next) => {
  // Izinkan request dari Laravel development server
  const allowedOrigins = process.env.ALLOWED_ORIGINS 
    ? process.env.ALLOWED_ORIGINS.split(',') 
    : [
        'http://localhost:8000',
        'http://127.0.0.1:8000',
        'http://localhost',
        'http://127.0.0.1'
      ];
  
  const origin = req.headers.origin;
  if (allowedOrigins.includes(origin)) {
    res.setHeader('Access-Control-Allow-Origin', origin);
  }
  
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
  res.setHeader('Access-Control-Allow-Credentials', 'true');
  
  // Handle preflight requests
  if (req.method === 'OPTIONS') {
    return res.status(200).end();
  }
  
  next();
});

app.use(express.json());
app.use(express.static('public'));

// ======== Penyimpanan data training lokal =========
const TRAIN_FILE = process.env.TRAIN_DATA_FILE || './data/train.json';
if (!fs.existsSync(TRAIN_FILE)) fs.writeFileSync(TRAIN_FILE, JSON.stringify([]));

function readTrainData() {
  try { return JSON.parse(fs.readFileSync(TRAIN_FILE)); }
  catch(e){ return []; }
}
function writeTrainData(d){ fs.writeFileSync(TRAIN_FILE, JSON.stringify(d, null, 2)); }

// ======== Fungsi pencarian sederhana (RAG) =========
function findRelevantData(message, allData, maxResults = 5) {
  const queryWords = message.toLowerCase().split(/\s+/);
  const scores = allData.map(item => {
    let score = 0;
    const text = (item.text || item.question || '').toLowerCase();
    const answer = (item.answer || item.response || '').toLowerCase();
    
    queryWords.forEach(word => {
      if (word.length < 3) return; // abaikan kata pendek
      if (text.includes(word)) score += 2;
      if (answer.includes(word)) score += 1;
    });
    return { item, score };
  });

  return scores
    .filter(s => s.score > 0)
    .sort((a, b) => b.score - a.score)
    .slice(0, maxResults)
    .map(s => s.item);
}

// ======== Endpoint list data training =========
app.get('/api/data', (req, res) => {
  res.json({ ok:true, data: readTrainData() });
});

// ======== Upload data training =========
app.post('/api/train', upload.single('file'), (req, res) => {
  let items = [];
  if (req.file) {
    const raw = fs.readFileSync(req.file.path, 'utf8');
    try { items = JSON.parse(raw); } catch(e){ return res.status(400).json({ok:false, error:'file tidak valid JSON'}); }
    fs.unlinkSync(req.file.path);
  } else if (req.body && req.body.items) {
    try { items = JSON.parse(req.body.items); } catch(e){ return res.status(400).json({ok:false, error:'items harus JSON'}); }
  } else {
    return res.status(400).json({ ok:false, error: 'Kirim file JSON atau field items' });
  }

  const cur = readTrainData();
  const existingIds = new Set(cur.map(d => d.id));
  const newItems = items.filter(item => item.id && !existingIds.has(item.id));
  const skipped = items.length - newItems.length;

  if (newItems.length > 0) {
    const merged = cur.concat(newItems);
    writeTrainData(merged);
    res.json({ ok:true, added: newItems.length, skipped, total: merged.length });
  } else {
    res.json({ ok:true, added: 0, skipped, total: cur.length, message: "Tidak ada data baru (mungkin duplikat)." });
  }
});

// ======== Endpoint chat dengan Gemini API =========
app.post('/api/chat', async (req, res) => {
  const { message, history } = req.body || {}; // Ambil history dari app.js
  if (!message) return res.status(400).json({ ok:false, error: 'message kosong' });

  const allData = readTrainData();
  const relevantData = findRelevantData(message, allData);
  const grounding = relevantData.length > 0
    ? "Gunakan data referensi berikut untuk membantu menjawab:\n" + 
      relevantData.map(d => (d.text||d.question||d.prompt) + '\n' + (d.answer||d.response||'' )).join('\n---\n')
    : "Tidak ditemukan data referensi lokal.";

  // System prompt untuk format jawaban yang lebih baik
  const systemPrompt = `Anda adalah asisten virtual Kelurahan Marga Sari yang ramah dan membantu.

PANDUAN MENJAWAB:
1. Jawab dengan bahasa Indonesia yang sopan dan mudah dipahami
2. Gunakan format yang rapi:
   - Untuk list: gunakan bullet points (•) atau numbering (1, 2, 3)
   - Untuk informasi penting: **bold** atau KAPITAL
   - Pisahkan paragraf dengan enter kosong
3. Jawaban singkat & padat (maksimal 150 kata)
4. Jika ada alamat/lokasi: tulis jelas dengan format:
   📍 Alamat: ...
5. Jika ada jam operasional: tulis format:
   ⏰ Jam Buka: ...
6. Akhiri dengan pertanyaan follow-up jika perlu

CONTOH JAWABAN BAGUS:
"Untuk membuat KTP baru, berikut langkah-langkahnya:

1. Siapkan dokumen:
   • Fotokopi KK
   • Surat pengantar RT/RW

2. Datang ke kelurahan untuk surat pengantar

3. Bawa ke Disdukcapil untuk perekaman

📍 Disdukcapil Balikpapan:
Jl. Jenderal Sudirman No.1

⏰ Senin-Jumat: 08.00-16.00 WITA

Ada yang ingin ditanyakan lagi?"

Sekarang jawab pertanyaan user dengan mengikuti panduan di atas.`;

  // Load API Key from environment variable
  const apiKey = process.env.GEMINI_API_KEY;
  
  if (!apiKey) {
    return res.status(500).json({ 
      ok: false, 
      error: 'GEMINI_API_KEY tidak ditemukan di .env file' 
    });
  }

  try {
    // Gunakan model dari .env atau default ke gemini-2.0-flash (lebih stabil)
    const model = process.env.GEMINI_MODEL || 'gemini-2.0-flash';
    
    // Gunakan endpoint v1beta untuk compatibility
    const url = `https://generativelanguage.googleapis.com/v1beta/models/${model}:generateContent?key=${apiKey}`;

    const fullPrompt = systemPrompt + "\n\n" + grounding + "\n\n---\nPertanyaan user: " + message;
    
    const contents = [
      ...(history || []), // Sertakan history percakapan
      {
        role: "user",
        parts: [{ text: fullPrompt }] 
      }
    ];

    const response = await axios.post(url, {
      contents: contents, 
      generationConfig: {
        maxOutputTokens: 350,  // Batasi panjang jawaban (lebih ringkas)
        temperature: 0.7,      // Kreativitas sedang
        topP: 0.9,
        topK: 40
      }
    }, {
      headers: {
        'Content-Type': 'application/json'
      },
      timeout: parseInt(process.env.API_TIMEOUT || '30000') // 30 detik timeout
    });

    const out = response.data || {};
    if (!out.candidates || !out.candidates[0].content) {
      throw new Error("Respon API v1beta tidak valid: " + JSON.stringify(out));
    }

    // Kembalikan seluruh objek 'out' agar app.js bisa parse
    return res.json({ ok:true, model, output: out });

  } catch (err) {
    const errorMsg = err.response && err.response.data && err.response.data.error 
      ? err.response.data.error.message 
      : err.message;
    console.error('Gemini error', errorMsg);
    
    const errorDetail = err.response && err.response.data ? err.response.data : { message: err.message };
    return res.status(500).json({ ok:false, error: 'Error saat memanggil Gemini API', detail: errorDetail });
  }
});

app.listen(PORT, () => console.log('Server running on port', PORT));