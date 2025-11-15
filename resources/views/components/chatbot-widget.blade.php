{{-- 
    CHATBOT WIDGET COMPONENT - VERCEL INTEGRATION
    
    Komponen chatbot yang terhubung ke Vercel deployment.
    Menggunakan iframe untuk embed chatbot yang sudah di-deploy.
    
    Usage: @include('components.chatbot-widget')
--}}

<!-- Chatbot Widget -->
<div id="chatbot-widget">
    <!-- Floating Button -->
    <button id="chatbot-toggle" class="chatbot-toggle-btn" type="button" aria-label="Buka Chatbot">
        <i class="bi bi-chat-dots-fill"></i>
    </button>

    <!-- Chatbot Modal/Popup -->
    <div id="chatbot-modal" class="chatbot-modal">
        <div class="chatbot-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-robot"></i>
                <span class="fw-bold">Asisten Virtual Kelurahan</span>
            </div>
            <button id="chatbot-close" class="chatbot-close-btn" type="button" aria-label="Tutup Chatbot">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="chatbot-body">
            <iframe 
                id="chatbot-iframe"
                src="https://kelurahan-chatbot-gemini-7gw3lusv1.vercel.app/ui"
                frameborder="0"
                allow="microphone"
                loading="lazy"
                title="Chatbot Asisten Virtual"
            ></iframe>
        </div>
    </div>
</div>

<style>
/* Chatbot Widget Styles */
#chatbot-widget {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
}

/* Floating Button */
.chatbot-toggle-btn {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    color: white;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.chatbot-toggle-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

.chatbot-toggle-btn:active {
    transform: scale(0.95);
}

/* Chatbot Modal */
.chatbot-modal {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 400px;
    height: 600px;
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    animation: slideUp 0.3s ease;
}

.chatbot-modal.active {
    display: flex;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Header */
.chatbot-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-shrink: 0;
}

.chatbot-close-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.chatbot-close-btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Body */
.chatbot-body {
    flex: 1;
    overflow: hidden;
    position: relative;
}

.chatbot-body iframe {
    width: 100%;
    height: 100%;
    border: none;
}

/* Responsive */
@media (max-width: 768px) {
    #chatbot-widget {
        bottom: 15px;
        right: 15px;
    }

    .chatbot-toggle-btn {
        width: 56px;
        height: 56px;
        font-size: 22px;
    }

    .chatbot-modal {
        bottom: 80px;
        right: 15px;
        left: 15px;
        width: auto;
        height: 500px;
        max-height: calc(100vh - 100px);
    }
}

@media (max-width: 480px) {
    .chatbot-modal {
        height: 450px;
    }
}

/* Hide on print */
@media print {
    #chatbot-widget {
        display: none !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('chatbot-toggle');
    const closeBtn = document.getElementById('chatbot-close');
    const modal = document.getElementById('chatbot-modal');
    
    if (!toggleBtn || !closeBtn || !modal) return;
    
    // Toggle chatbot
    toggleBtn.addEventListener('click', function() {
        modal.classList.toggle('active');
    });
    
    // Close chatbot
    closeBtn.addEventListener('click', function() {
        modal.classList.remove('active');
    });
    
    // Optional: Close when clicking outside
    document.addEventListener('click', function(e) {
        if (!modal.contains(e.target) && !toggleBtn.contains(e.target) && modal.classList.contains('active')) {
            // Uncomment to enable close on outside click
            // modal.classList.remove('active');
        }
    });
});
</script>
