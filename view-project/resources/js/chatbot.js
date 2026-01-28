document.addEventListener('DOMContentLoaded', () => {
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatContainer = document.getElementById('chat-container');

    if (!chatForm || !chatInput || !chatContainer) return;

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute('content');

    function addMessage(text, isUser = true, animate = true) {
        const templateId = isUser ? 'bubble-user-template' : 'bubble-bot-template';
        const template = document.getElementById(templateId);
        const node = template.content.cloneNode(true);

        node.querySelector('.message').textContent = text;
        node.querySelector('.time').textContent = new Date().toLocaleTimeString('es-MX', {
            hour: '2-digit',
            minute: '2-digit'
        });

        const bubble = node.querySelector('.chat-bubble');
        chatContainer.appendChild(node);

        if (animate) {
            requestAnimationFrame(() => {
                bubble.classList.remove('opacity-0', 'translate-y-2');
            });
        }

        chatContainer.scrollTo({
            top: chatContainer.scrollHeight,
            behavior: 'smooth'
        });
    }

    function sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        const message = chatInput.value.trim();
        if (!message) return;

        addMessage(message);
        chatInput.value = '';

        try {
            const response = await fetch('/chatbot', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message })
            });

            const data = await response.json();
            const botResponse =
                data.response || data.reply || 'No recibí respuesta del servidor.';

            await sleep(400);
            addMessage(botResponse, false);

        } catch (error) {
            //console.error(error);
            await sleep(400);
            addMessage(
                'Lo siento, ocurrió un error. Intenta nuevamente.',
                false
            );
        }
    });

    chatInput.focus();
});