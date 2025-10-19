# 🧪 TESTING FALLBACK SYSTEM

## 📋 **TEST PLAN**

Mari test 3-layer fallback system untuk memastikan chatbot tetap berjalan meskipun Gemini berbayar.

---

## ✅ **TEST 1: Normal Operation (Layer 1 - Gemini 2.0)**

### **Test Case:**
```
User Question: "Jam operasional kelurahan?"
Expected: Gemini 2.0 Flash menjawab
```

### **How to Test:**
1. Buka: http://localhost:8000/
2. Klik icon chatbot
3. Tanya: "Jam operasional kelurahan?"
4. Check server log:
   ```
   🤖 Trying model: gemini-2.0-flash-exp
   ✅ Success with model: gemini-2.0-flash-exp
   ```

### **Expected Result:**
✅ Chatbot menjawab dengan benar
✅ Response cepat (< 3 detik)
✅ Log menunjukkan Layer 1 (Gemini 2.0) berhasil

---

## ✅ **TEST 2: Simulate Gemini 2.0 Berbayar (Layer 2 - Gemini 1.5)**

### **Test Case:**
```
Scenario: Gemini 2.0 error/berbayar
Expected: Automatic fallback ke Gemini 1.5 Flash
```

### **How to Simulate:**

**Option A: Change Model Temporarily**

Edit `.env`:
```bash
# Comment Gemini 2.0
# GEMINI_MODEL=gemini-2.0-flash-exp

# Use invalid model to force fallback
GEMINI_MODEL=gemini-9.9-invalid
```

Restart server:
```bash
npm start
```

**Option B: Block API (Advanced)**

Pakai firewall untuk block generativelanguage.googleapis.com temporarily.

### **Expected Result:**
```
Server Log:
🤖 Trying model: gemini-9.9-invalid
⚠️ Model gemini-9.9-invalid failed: [error message]
💡 Quota exhausted for gemini-9.9-invalid, trying next model...
🤖 Trying model: gemini-1.5-flash
✅ Success with model: gemini-1.5-flash
```

✅ Chatbot tetap menjawab (pakai Layer 2)
✅ User tidak tahu ada error
✅ Response sedikit lebih lambat (3-5 detik)

---

## ✅ **TEST 3: Simulate Quota Habis (Layer 3 - Local RAG)**

### **Test Case:**
```
Scenario: Semua Gemini quota habis
Expected: Fallback ke database lokal (train.json)
```

### **How to Simulate:**

**Option A: Invalid API Key**

Edit `.env`:
```bash
GEMINI_API_KEY=INVALID_KEY_FOR_TESTING
```

Restart server:
```bash
npm start
```

**Option B: No Internet Simulation**

Disconnect WiFi/LAN temporarily.

### **Test with Local Data:**

Ask questions that exist in `data/train.json`:

```
✅ "Bagaimana cara mengurus KTP baru?"
✅ "Apa saja syarat membuat e-KTP?"
✅ "Jam kerja kelurahan hari Senin?"
✅ "Apakah kantor kelurahan buka hari Sabtu?"
```

### **Expected Result:**
```
Server Log:
🤖 Trying model: gemini-2.0-flash-exp
⚠️ Model gemini-2.0-flash-exp failed: Invalid API key
🤖 Trying model: gemini-1.5-flash
⚠️ Model gemini-1.5-flash failed: Invalid API key
⚠️ All Gemini models failed, using local RAG fallback...
✅ Local RAG match found: "Bagaimana cara mengurus KTP baru?"
```

✅ Chatbot menjawab dari database lokal
✅ Response sangat cepat (< 1 detik, no API call)
✅ Ada catatan: "📌 *Informasi dari database lokal*"

---

## ✅ **TEST 4: Question Not in Database (Generic Fallback)**

### **Test Case:**
```
Scenario: Question tidak ada di train.json & Gemini error
Expected: Generic friendly message
```

### **Setup:**
Keep invalid API key from Test 3.

### **Ask:**
```
❓ "Kapan pemilu presiden 2029?"
❓ "Harga tanah di kelurahan berapa?"
❓ "Siapa ketua RT paling ganteng?"
```

### **Expected Result:**
```
Response:
"Maaf, saat ini sistem AI sedang sibuk dan saya tidak menemukan 
informasi yang tepat di database lokal.

Silakan hubungi kantor kelurahan langsung di jam kerja 
(Senin-Jumat, 08:00-16:00 WITA) atau coba lagi beberapa saat lagi.

📞 Atau Anda bisa menghubungi staff kelurahan untuk informasi lebih lanjut."
```

✅ User mendapat response yang sopan
✅ User diarahkan ke kantor kelurahan
✅ Chatbot tidak error/crash

---

## 📊 **TEST RESULTS TABLE**

Setelah semua test, isi table ini:

| Test | Layer | Status | Response Time | Notes |
|------|-------|--------|---------------|-------|
| Normal (Gemini 2.0) | Layer 1 | ⏳ Pending | - | - |
| Fallback to 1.5 | Layer 2 | ⏳ Pending | - | - |
| Local RAG | Layer 3 | ⏳ Pending | - | - |
| Generic Fallback | Layer 3 | ⏳ Pending | - | - |

**Example (After Testing):**
| Test | Layer | Status | Response Time | Notes |
|------|-------|--------|---------------|-------|
| Normal (Gemini 2.0) | Layer 1 | ✅ Pass | 2.5s | Perfect! |
| Fallback to 1.5 | Layer 2 | ✅ Pass | 4.1s | Slower but works |
| Local RAG | Layer 3 | ✅ Pass | 0.3s | Very fast! |
| Generic Fallback | Layer 3 | ✅ Pass | 0.1s | Friendly message |

---

## 🎯 **SUCCESS CRITERIA**

Fallback system **LULUS** jika:

✅ **Layer 1 (Gemini 2.0):** Response cepat & akurat (< 3 detik)
✅ **Layer 2 (Gemini 1.5):** Auto-fallback works tanpa user notice
✅ **Layer 3 (Local RAG):** Jawab pertanyaan umum dengan benar
✅ **Generic Fallback:** User mendapat pesan yang sopan & helpful

**CRITICAL:** Chatbot **TIDAK PERNAH CRASH** di semua skenario!

---

## 🔧 **RESTORE AFTER TESTING**

Setelah semua test selesai, kembalikan ke setting normal:

### **1. Restore `.env`:**
```bash
# Gemini API Configuration
GEMINI_API_KEY=AIzaSyACOcup-YUg0VtIQQ4dHRq1ATv5YcE9knA
GEMINI_MODEL=gemini-2.0-flash-exp
```

### **2. Restart Server:**
```bash
npm start
```

### **3. Final Test:**
```
Ask: "Halo!"
Expected: Gemini 2.0 respond normally
```

✅ **System Ready for Production!**

---

## 📞 **TROUBLESHOOTING**

### **Problem: Server tidak start**
```bash
# Check port 3000 free
netstat -ano | findstr :3000

# Kill process if needed
Stop-Process -Id [PID] -Force

# Restart
npm start
```

### **Problem: Semua layer gagal**
```
Check:
1. API key valid? (https://aistudio.google.com/)
2. train.json ada? (data/train.json)
3. Internet connection OK?
4. Server log ada error?
```

### **Problem: Local RAG tidak match**
```
Solution:
1. Tambahkan pertanyaan ke train.json
2. Gunakan keyword yang sama dengan user
3. Restart server
```

---

## 🎉 **CONCLUSION**

Jika semua test **LULUS**, maka:

✅ **Chatbot production-ready untuk 1 tahun**
✅ **100% gratis guaranteed**
✅ **Tidak akan down meskipun Gemini berbayar**
✅ **User experience tetap baik di semua skenario**

**Status:** ⏳ Ready to Test  
**Next:** Run tests above and update results table

🚀 **GOOD LUCK TESTING!**
