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

// Voice Assistant State
let recognition = null;
let synthesis = window.speechSynthesis;
let isListening = false;
let isSpeaking = false;
let voiceSupported = false;
let lastInputMethod = 'text'; // 'text' or 'voice'

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
    
    // Add welcome message
    addBotMessage('Halo! Saya adalah asisten virtual Kelurahan Marga Sari. Ada yang bisa saya bantu? 🎙️ Anda bisa mengetik atau menggunakan tombol mikrofon untuk berbicara.', null, false, true);
    
    console.log('Chatbot initialized successfully');
    console.log('Voice Assistant:', voiceSupported ? 'Supported ✅' : 'Not Supported ❌');
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
    
    // Auto-play TTS ONLY if:
    // 1. Not welcome message
    // 2. Not thinking indicator
    // 3. Voice is supported
    // 4. Last input was via VOICE (not text)
    if (!isWelcome && !isThinking && text && voiceSupported && lastInputMethod === 'voice') {
        speakText(text);
    }
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
        
        console.log('📝 Transcript:', transcript, '| Final:', isFinal);
    };
    
    // Event: Speech Recognition End
    recognition.onend = function() {
        isListening = false;
        updateVoiceButton();
        hideVoiceStatus();
        
        // Get final transcript from transcription element
        const finalTranscript = elements.voiceTranscription?.textContent;
        
        if (finalTranscript && finalTranscript.trim()) {
            // Set input value and send message
            elements.inputField.value = finalTranscript.trim();
            hideTranscription();
            lastInputMethod = 'voice'; // Mark as voice input
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
    
    elements.voiceTranscription.textContent = text;
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
    
    if (!cleanText) return;
    
    // Create speech utterance
    const utterance = new SpeechSynthesisUtterance(cleanText);
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
