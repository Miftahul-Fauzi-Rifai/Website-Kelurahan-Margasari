/**
 * CHATBOT WIDGET - Laravel Integration
 * Menggunakan API dari Node.js server terpisah
 * 
 * Config: Ubah CHATBOT_API_URL sesuai dengan URL server Node.js Anda
 */

// ========== CONFIGURATION ==========
// Dynamic API URL - akan diisi oleh Laravel Blade
const CHATBOT_API_URL = window.CHATBOT_CONFIG?.apiUrl || 'http://localhost:3000';
const CHATBOT_ENABLED = window.CHATBOT_CONFIG?.enabled !== false; // Default true

// ========== STATE MANAGEMENT ==========
let chatHistory = [];
let isOpen = false;
let isProcessing = false;

// ========== LOCALSTORAGE KEYS ==========
// NOTE: Using sessionStorage for chat history (cleared on browser close)
// Using localStorage only for persistent preferences
const STORAGE_KEYS = {
    CHAT_HISTORY: 'chatbot_history',      // sessionStorage - cleared on close
    CHAT_MESSAGES: 'chatbot_messages',    // sessionStorage - cleared on close
    LAST_UPDATED: 'chatbot_last_updated'  // sessionStorage - cleared on close
};

// Voice Assistant State
let recognition = null;
let synthesis = window.speechSynthesis;
let isListening = false;
let isSpeaking = false;
let voiceSupported = false;
let lastInputMethod = 'text'; // 'text' or 'voice'

// ========== VOICE CORRECTION DICTIONARY ==========
// Mapping kata yang sering salah dikenali oleh Speech Recognition
const voiceCorrections = {
    // Akronim dan istilah khusus
    'es ka ce ka': 'SKCK',
    'eskck': 'SKCK',
    'esekck': 'SKCK',
    'skck': 'SKCK',
    'surat keterangan catatan kepolisian': 'SKCK',
    'es ka ka': 'SKK',
    'ka te pe': 'KTP',
    'e ktp': 'e-KTP',
    'ektp': 'e-KTP',
    'ktp elektronik': 'e-KTP',
    'ka ka': 'KK',
    'kartu keluarga': 'KK',
    'es te en ka': 'STNK',
    'stnk': 'STNK',
    'es im': 'SIM',
    'sim': 'SIM',
    'surat izin mengemudi': 'SIM',
    'be pe ka be': 'BPKB',
    'bpkb': 'BPKB',
    'en pe we pe': 'NPWP',
    'n p w p': 'NPWP',
    'en pe double u pe': 'NPWP',
    'en pe dabel yu pe': 'NPWP',
    'enpewp': 'NPWP',
    'npwp': 'NPWP',
    'nomor pokok wajib pajak': 'NPWP',
    'pe be be': 'PBB',
    'pbb': 'PBB',
    'pajak bumi dan bangunan': 'PBB',
    'disdukcapil': 'Disdukcapil',
    'dinas kependudukan': 'Disdukcapil',
    'pe de a em': 'PDAM',
    'pdam': 'PDAM',
    'be pe en': 'BPN',
    'bpn': 'BPN',
    'badan pertanahan': 'BPN',
    'ka u a': 'KUA',
    'kua': 'KUA',
    'kantor urusan agama': 'KUA',
    'ka i a': 'KIA',
    'kia': 'KIA',
    'kartu identitas anak': 'KIA',
    'satpas': 'Satpas',
    'sat pas': 'Satpas',
    'a ka satu': 'AK1',
    'ak1': 'AK1',
    'kartu kuning': 'AK1',
    'disnaker': 'Disnaker',
    'dinas tenaga kerja': 'Disnaker',
    'en i be': 'NIB',
    'nib': 'NIB',
    'nomor induk berusaha': 'NIB',
    'o es es': 'OSS',
    'oss': 'OSS',
    'de ce em': 'DCM',
    'dcm': 'DCM',
    'dicetak mandiri': 'DCM',
    'sim be ge': 'SIMBG',
    'simbg': 'SIMBG',
    'i em be': 'IMB',
    'imb': 'IMB',
    'izin mendirikan bangunan': 'IMB',
    'pe be ge': 'PBG',
    'pbg': 'PBG',
    'persetujuan bangunan gedung': 'PBG',
    'de pe em pe te': 'DPMPT',
    'dpmpt': 'DPMPT',
    'be pe pe de er de': 'BPPDRD',
    'bppdrd': 'BPPDRD',
    'es ka pe we en i': 'SKPWNI',
    'skpwni': 'SKPWNI',
    'surat keterangan pindah': 'SKPWNI',
    'sinar': 'SINAR',
    'sim nasional': 'SINAR',
    'lapor': 'LAPOR!',
    'layanan pengaduan': 'LAPOR!',
    
    // Nama tempat di Balikpapan
    'balikpapan': 'Balikpapan',
    'marga sari': 'Marga Sari',
    'margasari': 'Marga Sari',
    'kelurahan': 'kelurahan',
    'kecamatan': 'kecamatan',
    
    // Istilah umum yang sering salah
    'akta kelahiran': 'akta kelahiran',
    'akta kematian': 'akta kematian',
    'surat domisili': 'surat domisili',
    'surat keterangan usaha': 'surat keterangan usaha',
    'surat nikah': 'surat nikah',
    'surat pengantar': 'surat pengantar',
    
    // Jalan-jalan
    'jalan mt haryono': 'Jl. MT Haryono',
    'jalan jenderal sudirman': 'Jl. Jenderal Sudirman',
    'jalan sudirman': 'Jl. Sudirman',
    
    // Waktu
    'wita': 'WITA',
    'jam kerja': 'jam kerja'
};

// ========== DOM ELEMENTS ==========
const elements = {
    toggle: null,
    popup: null,
    chatBody: null,
    inputField: null,
    sendButton: null,
    clearButton: null,
    closeButton: null,
    voiceButton: null,
    voiceStatus: null,
    voiceTranscription: null
};

/**
 * Save chat history to sessionStorage (only persists during browser session)
 * Chat will be cleared when user closes browser/tab
 */
function saveChatToStorage() {
    try {
        // Use sessionStorage instead of localStorage
        // sessionStorage is cleared when browser/tab is closed
        sessionStorage.setItem(STORAGE_KEYS.CHAT_HISTORY, JSON.stringify(chatHistory));
        sessionStorage.setItem(STORAGE_KEYS.LAST_UPDATED, Date.now().toString());
        
        // Save visual messages (HTML content)
        const messages = [];
        const messageElements = elements.chatBody?.querySelectorAll('.chatbot-message');
        
        if (messageElements) {
            messageElements.forEach(msg => {
                const isUser = msg.classList.contains('user');
                const content = msg.querySelector('.chatbot-message-content')?.innerHTML || '';
                messages.push({ isUser, content });
            });
        }
        
        sessionStorage.setItem(STORAGE_KEYS.CHAT_MESSAGES, JSON.stringify(messages));
        console.log('💾 Chat saved to sessionStorage (will clear on browser close)');
    } catch (error) {
        console.error('Failed to save chat:', error);
    }
}

/**
 * Load chat history from sessionStorage
 * Only loads if still in same browser session
 */
function loadChatFromStorage() {
    try {
        // Load from sessionStorage (only persists during browser session)
        const savedHistory = sessionStorage.getItem(STORAGE_KEYS.CHAT_HISTORY);
        if (savedHistory) {
            chatHistory = JSON.parse(savedHistory);
            console.log('📂 Loaded', chatHistory.length, 'history items from sessionStorage');
        }
        
        // Load visual messages
        const savedMessages = sessionStorage.getItem(STORAGE_KEYS.CHAT_MESSAGES);
        if (savedMessages && elements.chatBody) {
            const messages = JSON.parse(savedMessages);
            
            // Clear existing messages (except welcome message)
            elements.chatBody.innerHTML = '';
            
            // Restore messages
            messages.forEach(msg => {
                const messageDiv = document.createElement('div');
                messageDiv.className = msg.isUser ? 'chatbot-message user' : 'chatbot-message bot';
                messageDiv.innerHTML = `<div class="chatbot-message-content">${msg.content}</div>`;
                elements.chatBody.appendChild(messageDiv);
            });
            
            scrollToBottom();
            console.log('📂 Loaded', messages.length, 'visual messages from sessionStorage');
        }
        
        // Check last updated time (auto-clear after 24 hours even within same session)
        const lastUpdated = sessionStorage.getItem(STORAGE_KEYS.LAST_UPDATED);
        if (lastUpdated) {
            const hoursSinceUpdate = (Date.now() - parseInt(lastUpdated)) / (1000 * 60 * 60);
            console.log('🕐 Chat last updated:', hoursSinceUpdate.toFixed(1), 'hours ago');
            
            // Auto-clear if older than 24 hours
            if (hoursSinceUpdate > 24) {
                console.log('🧹 Chat too old (>24h), clearing...');
                clearChatStorage();
            }
        }
    } catch (error) {
        console.error('Failed to load chat:', error);
    }
}

/**
 * Clear chat from sessionStorage
 */
function clearChatStorage() {
    try {
        sessionStorage.removeItem(STORAGE_KEYS.CHAT_HISTORY);
        sessionStorage.removeItem(STORAGE_KEYS.CHAT_MESSAGES);
        sessionStorage.removeItem(STORAGE_KEYS.LAST_UPDATED);
        console.log('🧹 Chat storage cleared from sessionStorage');
    } catch (error) {
        console.error('Failed to clear chat storage:', error);
    }
}

/**
 * Initialize chatbot when DOM is ready
 */
document.addEventListener('DOMContentLoaded', function() {
    if (!CHATBOT_ENABLED) return;
    
    initializeChatbot();
});

/**
 * Initialize chatbot elements and event listeners
 */
function initializeChatbot() {
    // Get DOM elements
    elements.toggle = document.getElementById('chatbot-toggle');
    elements.popup = document.getElementById('chatbot-popup');
    elements.chatBody = document.getElementById('chatbot-messages');
    elements.inputField = document.getElementById('chatbot-input');
    elements.sendButton = document.getElementById('chatbot-send');
    elements.clearButton = document.getElementById('chatbot-clear');
    elements.closeButton = document.getElementById('chatbot-close');
    elements.voiceButton = document.getElementById('voice-button');
    elements.voiceStatus = document.getElementById('voice-status');
    elements.voiceTranscription = document.getElementById('voice-transcription');
    elements.stopVoiceButton = document.getElementById('stop-voice-button');
    
    // Check if all elements exist
    if (!elements.toggle || !elements.popup) {
        console.warn('Chatbot elements not found in DOM');
        return;
    }
    
    // Load chat history from localStorage
    loadChatFromStorage();
    
    // Initialize Voice Assistant
    initializeVoiceAssistant();
    
    // Attach event listeners
    elements.toggle.addEventListener('click', toggleChat);
    elements.closeButton?.addEventListener('click', toggleChat);
    elements.sendButton?.addEventListener('click', () => {
        lastInputMethod = 'text'; // Mark as text input
        sendMessage();
    });
    elements.clearButton?.addEventListener('click', clearChat);
    elements.voiceButton?.addEventListener('click', toggleVoiceInput);
    elements.stopVoiceButton?.addEventListener('click', stopSpeaking);
    
    // Handle Enter key in input
    elements.inputField?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            lastInputMethod = 'text'; // Mark as text input
            sendMessage();
        }
    });
    
    // Add welcome message only if no chat history
    if (chatHistory.length === 0) {
        addBotMessage('Halo! Saya adalah asisten virtual Kelurahan Marga Sari. Ada yang bisa saya bantu? 🎙️ Anda bisa mengetik atau menggunakan tombol mikrofon untuk berbicara.', null, false, true);
    }
    
    console.log('Chatbot initialized successfully');
    console.log('Voice Assistant:', voiceSupported ? 'Supported ✅' : 'Not Supported ❌');
    console.log('Chat History:', chatHistory.length, 'messages');
}

/**
 * Toggle chat popup open/close
 */
function toggleChat() {
    isOpen = !isOpen;
    
    if (isOpen) {
        elements.popup.classList.add('active');
        elements.inputField?.focus();
        
        // Update toggle button icon
        if (elements.toggle) {
            elements.toggle.innerHTML = '<i class="bi bi-x-lg"></i>';
        }
    } else {
        elements.popup.classList.remove('active');
        
        // Update toggle button icon
        if (elements.toggle) {
            elements.toggle.innerHTML = '<i class="bi bi-chat-dots"></i>';
        }
    }
}

/**
 * Send message to chatbot API
 */
async function sendMessage() {
    if (isProcessing) return;
    
    const message = elements.inputField?.value.trim();
    if (!message) return;
    
    // Clear input
    elements.inputField.value = '';
    
    // Add user message to chat
    addUserMessage(message);
    
    // Show thinking indicator
    const thinkingId = 'thinking-' + Date.now();
    addBotMessage('<i>Sedang berpikir...</i>', thinkingId, true);
    
    // Set processing state
    isProcessing = true;
    updateSendButtonState();
    
    // Add to chat history
    chatHistory.push({
        role: "user",
        parts: [{ text: message }]
    });
    
    try {
        // Call Node.js API
        const response = await fetch(`${CHATBOT_API_URL}/api/chat`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                message: message, 
                history: chatHistory 
            })
        });
        
        // Remove thinking indicator
        const thinkingMsg = document.getElementById(thinkingId);
        if (thinkingMsg) thinkingMsg.remove();
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        let botResponse = '';
        
        // Parse response
        if (data.ok && data.output?.candidates?.[0]?.content?.parts?.[0]?.text) {
            botResponse = data.output.candidates[0].content.parts[0].text;
            addBotMessage(botResponse);
        } else if (data.ok && data.output?.candidates?.[0]?.finishReason === 'SAFETY') {
            const blockReason = data.output.promptFeedback?.blockReason || 'Filter keamanan';
            botResponse = `Maaf, respons diblokir karena: ${blockReason}`;
            addBotMessage(botResponse);
        } else if (!data.ok) {
            botResponse = 'Maaf, terjadi kesalahan: ' + (data.error || 'Error tidak diketahui');
            addBotMessage(botResponse);
        } else {
            botResponse = 'Maaf, saya tidak dapat memproses pertanyaan Anda saat ini.';
            addBotMessage(botResponse);
        }
        
        // Add bot response to history
        chatHistory.push({
            role: "model",
            parts: [{ text: botResponse }]
        });
        
    } catch (error) {
        console.error('Chatbot error:', error);
        
        // Remove thinking indicator
        const thinkingMsg = document.getElementById(thinkingId);
        if (thinkingMsg) thinkingMsg.remove();
        
        // Show error message
        const errorMessage = error.message.includes('Failed to fetch') 
            ? 'Tidak dapat terhubung ke server chatbot. Pastikan server Node.js berjalan di ' + CHATBOT_API_URL
            : 'Terjadi kesalahan: ' + error.message;
        
        addBotMessage(errorMessage);
    } finally {
        isProcessing = false;
        updateSendButtonState();
    }
}

/**
 * Add user message to chat
 */
function addUserMessage(text) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'chatbot-message user';
    messageDiv.innerHTML = `
        <div class="chatbot-message-content">${escapeHtml(text)}</div>
    `;
    
    elements.chatBody?.appendChild(messageDiv);
    scrollToBottom();
    
    // Save to localStorage
    saveChatToStorage();
}

/**
 * Add bot message to chat
 */
function addBotMessage(text, id = null, isThinking = false, isWelcome = false) {
    const messageDiv = document.createElement('div');
    messageDiv.className = 'chatbot-message bot';
    if (id) messageDiv.id = id;
    
    const contentClass = isThinking ? 'chatbot-message-content thinking' : 'chatbot-message-content';
    
    // If it's HTML (like thinking indicator), render as-is, otherwise escape
    const content = isThinking 
        ? text 
        : `<pre style="margin: 0; font-family: inherit; white-space: pre-wrap;">${escapeHtml(text)}</pre>`;
    
    messageDiv.innerHTML = `
        <div class="${contentClass}">${content}</div>
    `;
    
    elements.chatBody?.appendChild(messageDiv);
    scrollToBottom();
    
    // Save to localStorage (skip for thinking indicators)
    if (!isThinking) {
        saveChatToStorage();
    }
    
    // Auto-play TTS ONLY if:
    // 1. Not welcome message
    // 2. Not thinking indicator
    // 3. Voice is supported
    // 4. Last input was via VOICE (not text)
    if (!isWelcome && !isThinking && text && voiceSupported && lastInputMethod === 'voice') {
        speakText(text);
    }
}

/**
 * Correct voice transcript using dictionary and fuzzy matching
 */
function correctVoiceTranscript(transcript) {
    if (!transcript) return transcript;
    
    let corrected = transcript.toLowerCase();
    
    // Apply corrections from dictionary
    for (const [wrong, correct] of Object.entries(voiceCorrections)) {
        // Use word boundary to avoid partial matches
        const regex = new RegExp('\\b' + wrong.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '\\b', 'gi');
        corrected = corrected.replace(regex, correct);
    }
    
    // Additional fuzzy matching for common patterns
    corrected = corrected
        // Fix spacing in acronyms (e.g., "s k c k" -> "SKCK")
        .replace(/\b([a-z])\s+([a-z])\s+([a-z])\s+([a-z])\s*\b/gi, function(match, p1, p2, p3, p4) {
            const acronym = (p1 + p2 + p3 + p4).toUpperCase();
            // Check if this acronym exists in our corrections
            if (voiceCorrections[acronym.toLowerCase()] || 
                acronym === 'SKCK' || acronym === 'STNK' || acronym === 'NPWP' || 
                acronym === 'PDAM' || acronym === 'BPKB') {
                return voiceCorrections[acronym.toLowerCase()] || acronym;
            }
            return match;
        })
        // Fix 2-letter acronyms (e.g., "k k" -> "KK")
        .replace(/\b([a-z])\s+([a-z])\s*\b/gi, function(match, p1, p2) {
            const acronym = (p1 + p2).toUpperCase();
            if (acronym === 'KK' || acronym === 'KA' || acronym === 'RT' || acronym === 'RW') {
                return voiceCorrections[acronym.toLowerCase()] || acronym;
            }
            return match;
        })
        // Fix 3-letter acronyms (e.g., "k t p" -> "KTP")
        .replace(/\b([a-z])\s+([a-z])\s+([a-z])\s*\b/gi, function(match, p1, p2, p3) {
            const acronym = (p1 + p2 + p3).toUpperCase();
            if (acronym === 'KTP' || acronym === 'SIM' || acronym === 'BPN' || 
                acronym === 'KUA' || acronym === 'KIA' || acronym === 'PBB' ||
                acronym === 'NIB' || acronym === 'OSS' || acronym === 'DCM' ||
                acronym === 'IMB' || acronym === 'PBG') {
                return voiceCorrections[acronym.toLowerCase()] || acronym;
            }
            return match;
        })
        // Fix 4-letter acronyms (e.g., "n p w p" -> "NPWP")
        .replace(/\b([a-z])\s+([a-z])\s+([a-z])\s+([a-z])\s*\b/gi, function(match, p1, p2, p3, p4) {
            const acronym = (p1 + p2 + p3 + p4).toUpperCase();
            if (acronym === 'NPWP' || acronym === 'STNK' || acronym === 'BPKB' || 
                acronym === 'PDAM' || acronym === 'SKCK') {
                return voiceCorrections[acronym.toLowerCase()] || acronym;
            }
            return match;
        });
    
    // Capitalize first letter
    corrected = corrected.charAt(0).toUpperCase() + corrected.slice(1);
    
    console.log('🔧 Voice correction:', transcript, '->', corrected);
    return corrected;
}

// ========================================
// VOICE ASSISTANT FUNCTIONS
// ========================================

/**
 * Initialize Voice Assistant (Speech Recognition & Synthesis)
 */
function initializeVoiceAssistant() {
    // Check if Speech Recognition is supported
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    
    if (!SpeechRecognition) {
        console.warn('Speech Recognition not supported in this browser');
        if (elements.voiceButton) {
            elements.voiceButton.classList.add('not-supported');
            elements.voiceButton.title = 'Voice input not supported in this browser';
            elements.voiceButton.disabled = true;
        }
        return;
    }
    
    voiceSupported = true;
    
    // Initialize Speech Recognition
    recognition = new SpeechRecognition();
    recognition.lang = 'id-ID'; // Bahasa Indonesia
    recognition.continuous = false; // Stop after one sentence
    recognition.interimResults = true; // Show real-time transcription
    recognition.maxAlternatives = 1;
    
    // Event: Speech Recognition Start
    recognition.onstart = function() {
        isListening = true;
        updateVoiceButton();
        showVoiceStatus();
        console.log('🎙️ Voice recognition started');
    };
    
    // Event: Speech Recognition Result
    recognition.onresult = function(event) {
        const transcript = event.results[0][0].transcript;
        const isFinal = event.results[0].isFinal;
        
        // Show real-time transcription
        updateTranscription(transcript, isFinal);
        
        console.log('📝 Raw Transcript:', transcript, '| Final:', isFinal);
        
        // Debug: Show if NPWP-related words are detected
        if (isFinal && /npwp|en pe|n p w p|wajib pajak/i.test(transcript)) {
            console.log('🔍 NPWP-related words detected in transcript!');
        }
    };
    
    // Event: Speech Recognition End
    recognition.onend = function() {
        isListening = false;
        updateVoiceButton();
        hideVoiceStatus();
        
        // Get final transcript from transcription element
        const finalTranscript = elements.voiceTranscription?.textContent;
        
        if (finalTranscript && finalTranscript.trim()) {
            // Apply voice correction to fix common misrecognitions
            const correctedTranscript = correctVoiceTranscript(finalTranscript.trim());
            
            // Set input value and send message
            elements.inputField.value = correctedTranscript;
            hideTranscription();
            lastInputMethod = 'voice'; // Mark as voice input
            
            // Show correction notification if text was corrected
            if (correctedTranscript !== finalTranscript.trim()) {
                console.log('✨ Transcript auto-corrected');
                // Optionally show a subtle notification
                const correctionNote = document.createElement('div');
                correctionNote.className = 'correction-note';
                correctionNote.textContent = '✨ Teks dikoreksi otomatis';
                correctionNote.style.cssText = 'position: absolute; top: 10px; right: 10px; background: #667eea; color: white; padding: 8px 12px; border-radius: 8px; font-size: 12px; opacity: 0; transition: opacity 0.3s;';
                elements.popup.appendChild(correctionNote);
                setTimeout(() => correctionNote.style.opacity = '1', 10);
                setTimeout(() => {
                    correctionNote.style.opacity = '0';
                    setTimeout(() => correctionNote.remove(), 300);
                }, 2000);
            }
            
            sendMessage();
        } else {
            hideTranscription();
        }
        
        console.log('🛑 Voice recognition ended');
    };
    
    // Event: Speech Recognition Error
    recognition.onerror = function(event) {
        console.error('❌ Voice recognition error:', event.error);
        isListening = false;
        updateVoiceButton();
        hideVoiceStatus();
        hideTranscription();
        
        // Show error message
        const errorMessages = {
            'no-speech': 'Tidak ada suara terdeteksi. Silakan coba lagi.',
            'audio-capture': 'Mikrofon tidak terdeteksi. Periksa pengaturan mikrofon Anda.',
            'not-allowed': 'Akses mikrofon ditolak. Izinkan akses mikrofon di browser.',
            'network': 'Tidak ada koneksi internet. Periksa koneksi Anda.',
            'aborted': 'Pengenalan suara dibatalkan.'
        };
        
        const errorMsg = errorMessages[event.error] || 'Terjadi kesalahan: ' + event.error;
        addBotMessage('🎙️ ' + errorMsg, null, false, true);
    };
    
    console.log('✅ Voice Assistant initialized');
}

/**
 * Toggle Voice Input (Start/Stop Listening)
 */
function toggleVoiceInput() {
    if (!voiceSupported || !recognition) {
        addBotMessage('🎙️ Voice input tidak didukung di browser ini. Silakan gunakan Chrome atau Edge.', null, false, true);
        return;
    }
    
    if (isListening) {
        // Stop listening
        recognition.stop();
    } else {
        // Start listening
        try {
            recognition.start();
        } catch (error) {
            console.error('Error starting recognition:', error);
            addBotMessage('🎙️ Gagal memulai pengenalan suara. Silakan coba lagi.', null, false, true);
        }
    }
}

/**
 * Update Voice Button State
 */
function updateVoiceButton() {
    if (!elements.voiceButton) return;
    
    if (isListening) {
        elements.voiceButton.classList.add('listening');
        elements.voiceButton.innerHTML = '<i class="bi bi-mic-mute-fill"></i>';
        elements.voiceButton.title = 'Berhenti Mendengarkan';
    } else {
        elements.voiceButton.classList.remove('listening');
        elements.voiceButton.innerHTML = '<i class="bi bi-mic-fill"></i>';
        elements.voiceButton.title = 'Gunakan Suara';
    }
}

/**
 * Show Voice Status Indicator
 */
function showVoiceStatus() {
    if (elements.voiceStatus) {
        elements.voiceStatus.style.display = 'block';
    }
}

/**
 * Hide Voice Status Indicator
 */
function hideVoiceStatus() {
    if (elements.voiceStatus) {
        elements.voiceStatus.style.display = 'none';
    }
}

/**
 * Update Real-time Transcription Display
 */
function updateTranscription(text, isFinal) {
    if (!elements.voiceTranscription) return;
    
    // Apply correction for better display
    const displayText = correctVoiceTranscript(text);
    
    elements.voiceTranscription.textContent = displayText;
    elements.voiceTranscription.style.display = 'block';
    
    if (isFinal) {
        elements.voiceTranscription.style.fontWeight = 'bold';
    }
}

/**
 * Hide Transcription Display
 */
function hideTranscription() {
    if (elements.voiceTranscription) {
        elements.voiceTranscription.style.display = 'none';
        elements.voiceTranscription.textContent = '';
    }
}

/**
 * Remove emojis from text for TTS
 */
function removeEmojis(text) {
    // Remove all emojis using regex
    return text
        // Remove emoji characters (Unicode ranges)
        .replace(/[\u{1F600}-\u{1F64F}]/gu, '') // Emoticons
        .replace(/[\u{1F300}-\u{1F5FF}]/gu, '') // Misc Symbols and Pictographs
        .replace(/[\u{1F680}-\u{1F6FF}]/gu, '') // Transport and Map
        .replace(/[\u{1F1E0}-\u{1F1FF}]/gu, '') // Flags
        .replace(/[\u{2600}-\u{26FF}]/gu, '')   // Misc symbols
        .replace(/[\u{2700}-\u{27BF}]/gu, '')   // Dingbats
        .replace(/[\u{1F900}-\u{1F9FF}]/gu, '') // Supplemental Symbols and Pictographs
        .replace(/[\u{1FA00}-\u{1FA6F}]/gu, '') // Chess Symbols
        .replace(/[\u{1FA70}-\u{1FAFF}]/gu, '') // Symbols and Pictographs Extended-A
        .replace(/[\u{2300}-\u{23FF}]/gu, '')   // Miscellaneous Technical
        // Remove bullet points and special characters often used with emojis
        .replace(/•/g, '-')                      // Replace bullet with dash
        .replace(/→/g, 'ke')                     // Replace arrow
        .replace(/✅/g, '')                       // Checkmarks
        .replace(/❌/g, '')                       // Cross marks
        .replace(/⚠️/g, 'Perhatian:')           // Warning
        .replace(/📌/g, '')                       // Pin
        .replace(/💡/g, '')                       // Light bulb
        // Clean up multiple spaces and trim
        .replace(/\s+/g, ' ')
        .trim();
}

/**
 * Text-to-Speech: Speak the given text
 */
function speakText(text) {
    if (!synthesis) return;
    
    // Cancel any ongoing speech
    if (isSpeaking) {
        synthesis.cancel();
    }
    
    // Show stop button
    showStopVoiceButton();
    
    // Clean text for better speech
    const cleanText = text
        .replace(/```[\s\S]*?```/g, '') // Remove code blocks
        .replace(/`[^`]*`/g, '') // Remove inline code
        .replace(/\*\*/g, '') // Remove bold markers
        .replace(/\*/g, '') // Remove italic markers
        .replace(/\n\n+/g, '. ') // Replace multiple newlines with period
        .replace(/\n/g, ', ') // Replace single newlines with comma
        .trim();
    
    // Remove emojis for cleaner speech
    const textWithoutEmojis = removeEmojis(cleanText);
    
    if (!textWithoutEmojis) return;
    
    console.log('🔊 Speaking (without emojis):', textWithoutEmojis.substring(0, 50) + '...');
    
    // Create speech utterance
    const utterance = new SpeechSynthesisUtterance(textWithoutEmojis);
    utterance.lang = 'id-ID'; // Indonesian voice
    utterance.rate = 0.9; // Slightly slower for clarity
    utterance.pitch = 1.0;
    utterance.volume = 1.0;
    
    // Try to use Indonesian voice if available
    const voices = synthesis.getVoices();
    const indonesianVoice = voices.find(voice => 
        voice.lang.startsWith('id') || 
        voice.lang.startsWith('ID')
    );
    
    if (indonesianVoice) {
        utterance.voice = indonesianVoice;
        console.log('🔊 Using Indonesian voice:', indonesianVoice.name);
    } else {
        console.log('🔊 Using default voice');
    }
    
    // Event handlers
    utterance.onstart = function() {
        isSpeaking = true;
        showStopVoiceButton();
        console.log('🔊 Speaking started');
    };
    
    utterance.onend = function() {
        isSpeaking = false;
        hideStopVoiceButton();
        console.log('🔊 Speaking ended');
    };
    
    utterance.onerror = function(event) {
        isSpeaking = false;
        hideStopVoiceButton();
        console.error('🔊 Speech error:', event.error);
    };
    
    // Speak
    synthesis.speak(utterance);
}

/**
 * Stop current speech
 */
function stopSpeaking() {
    if (synthesis && isSpeaking) {
        synthesis.cancel();
        isSpeaking = false;
        hideStopVoiceButton();
        console.log('🛑 Speech stopped by user');
    }
}

/**
 * Show Stop Voice Button
 */
function showStopVoiceButton() {
    if (elements.stopVoiceButton) {
        elements.stopVoiceButton.style.display = 'flex';
    }
}

/**
 * Hide Stop Voice Button
 */
function hideStopVoiceButton() {
    if (elements.stopVoiceButton) {
        elements.stopVoiceButton.style.display = 'none';
    }
}

/**
 * Clear chat history
 */
function clearChat() {
    if (!confirm('Hapus semua riwayat percakapan?')) return;
    
    // Stop any ongoing speech
    stopSpeaking();
    
    // Stop any ongoing recognition
    if (isListening && recognition) {
        recognition.stop();
    }
    
    chatHistory = [];
    elements.chatBody.innerHTML = '';
    
    // Clear localStorage
    clearChatStorage();
    
    // Add welcome message again
    addBotMessage('Riwayat percakapan telah dihapus. Ada yang bisa saya bantu? 🎙️', null, false, true);
}

/**
 * Update send button state based on processing status
 */
function updateSendButtonState() {
    if (elements.sendButton) {
        elements.sendButton.disabled = isProcessing;
        elements.sendButton.style.opacity = isProcessing ? '0.5' : '1';
    }
}

/**
 * Scroll chat to bottom
 */
function scrollToBottom() {
    if (elements.chatBody) {
        elements.chatBody.scrollTop = elements.chatBody.scrollHeight;
    }
}

/**
 * Escape HTML to prevent XSS
 */
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

/**
 * Check if chatbot server is running
 */
async function checkServerStatus() {
    try {
        const response = await fetch(`${CHATBOT_API_URL}/api/data`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        return response.ok;
    } catch (error) {
        return false;
    }
}

// Export for testing/debugging
if (typeof window !== 'undefined') {
    window.chatbotWidget = {
        toggle: toggleChat,
        clear: clearChat,
        checkStatus: checkServerStatus,
        getHistory: () => chatHistory,
        config: {
            apiUrl: CHATBOT_API_URL,
            enabled: CHATBOT_ENABLED
        },
        voice: {
            isSupported: () => voiceSupported,
            isListening: () => isListening,
            isSpeaking: () => isSpeaking,
            toggleInput: toggleVoiceInput,
            speak: speakText,
            stop: stopSpeaking
        }
    };
}
