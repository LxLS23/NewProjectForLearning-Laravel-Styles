
function sendMessage() {
    fetch('/chatbot', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            message: document.getElementById('message').value
        })
    })
    .then(res => res.json())
    .then(data => {
        document.getElementById('chat-box').innerHTML +=
            `<p><strong>Bot:</strong> ${data.reply}</p>`;
    });
}

