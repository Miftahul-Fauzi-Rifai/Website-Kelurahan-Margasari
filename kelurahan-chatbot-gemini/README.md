# Chatbot Kelurahan - Gemini API + Voice Assistant

Proyek sederhana ini menunjukkan:
- Frontend HTML untuk chat & upload data training
- **Voice Assistant** dengan Speech Recognition & Text-to-Speech
- **Auto Voice Correction** untuk mengenali istilah khusus (SKCK, KTP, dll)
- Backend Node.js + Express yang:
  - Menyimpan data training di `data/train.json`
  - Endpoint `/api/train` untuk menambah data training (unggah file JSON atau kirim `items` JSON)
  - Endpoint `/api/chat` untuk mengirim prompt ke Gemini API (atau mensimulasikan jawaban jika GEMINI_API_KEY tidak di-set)

## ✨ Fitur Voice Correction
Sistem ini secara otomatis mengoreksi hasil speech recognition untuk istilah-istilah khusus seperti:
- **Akronim**: SKCK, KTP, e-KTP, KK, SIM, STNK, BPKB, NPWP, PBB, dll
- **Nama Instansi**: Disdukcapil, Satpas, BPN, KUA, Disnaker, DPMPT
- **Istilah Teknis**: NIB, OSS, DCM, SIMBG, IMB, PBG, SKPWNI, dll

### Cara Kerja:
1. User berbicara: "saya mau buat es ce ka ce ka"
2. Speech Recognition menangkap: "saya mau buat es ce ka ce ka"
3. **Auto Correction** mengubah menjadi: "Saya mau buat SKCK"
4. Chatbot memproses dengan istilah yang benar ✅

### Menambah Kata Baru:
Edit file `public/js/chatbot.js`, cari bagian `voiceCorrections` dan tambahkan:
```javascript
const voiceCorrections = {
    'kata yang salah': 'Kata Yang Benar',
    // contoh:
    'es ka a en': 'SKAN',
}
```

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
