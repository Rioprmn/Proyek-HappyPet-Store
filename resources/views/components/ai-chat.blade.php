<div class="ai-chat-widget" id="aiChatWidget">
    <button class="chat-toggle" id="chatToggle">💬</button>
    
    <div class="chat-box" id="chatBox">
        <div class="chat-header">
            <h3>AI Assistant</h3>
            <button class="chat-close" id="chatClose">✕</button>
        </div>
        
        <div class="chat-messages" id="chatMessages">
            <div class="message bot-message">
                <p>Halo! Ada yang bisa saya bantu tentang produk atau artikel kami?</p>
            </div>
        </div>
        
        <div class="chat-input-area">
            <input type="text" id="chatInput" placeholder="Ketik pertanyaan..." class="chat-input">
            <button id="chatSend" class="chat-send">Kirim</button>
        </div>
    </div>
</div>

<style>
    .ai-chat-widget {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 999;
        font-family: inherit;
    }

    .chat-toggle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #2c9a94;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(44, 154, 148, 0.3);
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-toggle:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(44, 154, 148, 0.4);
    }

    .chat-toggle.hidden {
        display: none;
    }

    .chat-box {
        display: none;
        position: absolute;
        bottom: 70px;
        right: 0;
        width: 350px;
        height: 500px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        flex-direction: column;
        overflow: hidden;
    }

    .chat-box.active {
        display: flex;
    }

    .chat-header {
        background: #2c9a94;
        color: white;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-header h3 {
        margin: 0;
        font-size: 1rem;
    }

    .chat-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 1.2rem;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 15px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .message {
        display: flex;
        margin-bottom: 10px;
    }

    .message p {
        margin: 0;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 0.9rem;
        max-width: 80%;
        word-wrap: break-word;
    }

    .bot-message p {
        background: #f0fdf4;
        color: #1e293b;
        border-left: 3px solid #2c9a94;
    }

    .user-message {
        justify-content: flex-end;
    }

    .user-message p {
        background: #2c9a94;
        color: white;
    }

    .chat-input-area {
        display: flex;
        gap: 8px;
        padding: 12px;
        border-top: 1px solid #e2e8f0;
        background: white;
    }

    .chat-input {
        flex: 1;
        padding: 8px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 0.9rem;
        font-family: inherit;
    }

    .chat-input:focus {
        outline: none;
        border-color: #2c9a94;
    }

    .chat-send {
        padding: 8px 16px;
        background: #2c9a94;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .chat-send:hover {
        background: #1a7a75;
    }

    @media (max-width: 480px) {
        .ai-chat-widget {
            bottom: 10px;
            right: 10px;
        }

        .chat-box {
            width: calc(100vw - 20px);
            height: 400px;
            bottom: 60px;
            right: -10px;
        }

        .chat-toggle {
            width: 45px;
            height: 45px;
            font-size: 1.3rem;
        }
    }
</style>

<script>
    const chatToggle = document.getElementById('chatToggle');
    const chatBox = document.getElementById('chatBox');
    const chatClose = document.getElementById('chatClose');
    const chatInput = document.getElementById('chatInput');
    const chatSend = document.getElementById('chatSend');
    const chatMessages = document.getElementById('chatMessages');

    chatToggle.addEventListener('click', function() {
        chatBox.classList.toggle('active');
        chatToggle.classList.toggle('hidden');
    });

    chatClose.addEventListener('click', function() {
        chatBox.classList.remove('active');
        chatToggle.classList.remove('hidden');
    });

    chatSend.addEventListener('click', sendMessage);
    chatInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });

    function sendMessage() {
        const message = chatInput.value.trim();
        if (!message) return;

        const userDiv = document.createElement('div');
        userDiv.className = 'message user-message';
        userDiv.innerHTML = `<p>${escapeHtml(message)}</p>`;
        chatMessages.appendChild(userDiv);

        chatInput.value = '';
        chatMessages.scrollTop = chatMessages.scrollHeight;

        fetch('/api/chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message: message })
        })
        .then(response => response.json())
        .then(data => {
            const botDiv = document.createElement('div');
            botDiv.className = 'message bot-message';
            botDiv.innerHTML = `<p>${escapeHtml(data.reply)}</p>`;
            chatMessages.appendChild(botDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        })
        .catch(error => {
            const botDiv = document.createElement('div');
            botDiv.className = 'message bot-message';
            botDiv.innerHTML = `<p>Maaf, terjadi kesalahan. Silakan coba lagi.</p>`;
            chatMessages.appendChild(botDiv);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        });
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
</script>
