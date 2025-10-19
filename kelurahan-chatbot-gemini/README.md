# Chatbot Kelurahan - Gemini API 

Proyek sederhana ini menunjukkan:
- Frontend HTML untuk chat & upload data training
- Backend Node.js + Express yang:
  - Menyimpan data training di `data/train.json`
  - Endpoint `/api/train` untuk menambah data training (unggah file JSON atau kirim `items` JSON)
  - Endpoint `/api/chat` untuk mengirim prompt ke Gemini API (atau mensimulasikan jawaban jika GEMINI_API_KEY tidak di-set)

## Cara pakai (lokal)
1. Pasang Node.js (v16+)
2. `npm install`
3. Set environment variable `GEMINI_API_KEY` jika Anda ingin memakai Gemini yang asli:
   - di Linux/macOS: `export GEMINI_API_KEY="TOKEN_ANDA"`
   - di Windows (PowerShell): `$env:GEMINI_API_KEY = "TOKEN_ANDA"`
4. `npm start`
5. Buka `http://localhost:3000`

## Format data training
File JSON berisi array objects, contoh `data/train.json`:
```json
[
  { "id":"1", "text":"Pertanyaan user", "answer":"Jawaban referensi" }
]
```

Backend akan menyertakan entri-entri terakhir sebagai "grounding" untuk membantu model menjawab.

## Catatan soal Gemini API (free tier)
Google menyediakan **free tier** untuk Gemini API (lihat dokumentasi resmi untuk detail model-rate limits dan cara upgrade billing). Pastikan mengecek kuota dan model yang tersedia di akun Google Anda sebelum mengandalkan penggunaan produksi. Referensi:
- Gemini API Pricing & Billing — Google AI docs. citeturn0search0turn0search1

## Lisensi
MIT
