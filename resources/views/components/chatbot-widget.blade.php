{{-- 
    CHATBOT WIDGET COMPONENT
    
    Komponen chatbot yang dapat diintegrasikan ke layout manapun.
    Tidak mengganggu struktur existing dan dapat di-toggle on/off.
    
    Usage: @include('components.chatbot-widget')
--}}

<!-- Chatbot Toggle Button -->
<button id="chatbot-toggle" type="button" aria-label="Toggle Chatbot">
    <i class="bi bi-chat-dots"></i>
</button>

<!-- Chatbot Popup Window -->
<div id="chatbot-popup">
    <!-- Header -->
    <div class="chatbot-header">
        <h3>
            <i class="bi bi-robot me-2"></i>
            Asisten Virtual
        </h3>
        <div class="chatbot-header-actions">
            <button id="chatbot-clear" type="button" title="Hapus Riwayat" aria-label="Clear Chat">
                <i class="bi bi-trash"></i>
            </button>
            <button id="chatbot-close" type="button" title="Tutup" aria-label="Close Chat">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </div>
    
    <!-- Chat Messages Area -->
    <div class="chatbot-body" id="chatbot-messages">
        <!-- Messages will be added here dynamically -->
    </div>
    
    <!-- Input Area -->
    <div class="chatbot-footer">
        <!-- Voice Status Indicator -->
        <div id="voice-status" class="voice-status" style="display: none;">
            <div class="voice-indicator">
                <span class="voice-text">Mendengarkan...</span>
                <div class="audio-wave">
                    <span class="wave-bar"></span>
                    <span class="wave-bar"></span>
                    <span class="wave-bar"></span>
                    <span class="wave-bar"></span>
                    <span class="wave-bar"></span>
                </div>
            </div>
        </div>
        
        <!-- Transcription Display -->
        <div id="voice-transcription" class="voice-transcription" style="display: none;"></div>
        
        <div class="chatbot-input-wrapper">
            <!-- Voice Input Button -->
            <button id="voice-button" type="button" title="Gunakan Suara" aria-label="Voice Input" class="voice-btn">
                <i class="bi bi-mic-fill"></i>
            </button>
            
            <!-- Stop Voice Button (Hidden by default) -->
            <button id="stop-voice-button" type="button" title="Hentikan Suara" aria-label="Stop Voice" class="stop-voice-btn" style="display: none;">
                <i class="bi bi-stop-circle-fill"></i>
            </button>
            
            <input 
                type="text" 
                id="chatbot-input" 
                placeholder="Ketik atau gunakan suara..." 
                autocomplete="off"
                aria-label="Chat Input"
            />
            <button id="chatbot-send" type="button" aria-label="Send Message">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>
</div>

{{-- CSS & JS Assets loaded directly in layout --}}
