document.getElementById('chat-form').addEventListener('submit', async function(event) {
    event.preventDefault();
    
    const userInput = document.getElementById('user-input').value.trim();
    if (userInput) {
        addMessageToChat(userInput, 'user');
        document.getElementById('user-input').value = '';

        // Show typing indicator
        const typingIndicator = showTypingIndicator();

        const botResponse = await getBotResponse(userInput);

        // Remove typing indicator once bot response is ready
        removeTypingIndicator(typingIndicator);

        addMessageToChat(botResponse, 'bot');
    }
});

function addMessageToChat(message, sender) {
    const chatBox = document.getElementById('chat-box');
    const messageElement = document.createElement('div');
    messageElement.classList.add('chat-message', sender);
    messageElement.textContent = message;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to the latest message
}

function showTypingIndicator() {
    const chatBox = document.getElementById('chat-box');
    const typingIndicator = document.createElement('div');
    typingIndicator.classList.add('typing-indicator');
    typingIndicator.innerHTML = '<span></span><span></span><span></span>';
    chatBox.appendChild(typingIndicator);
    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to the latest message
    return typingIndicator;
}

function removeTypingIndicator(typingIndicator) {
    if (typingIndicator) {
        typingIndicator.remove();
    }
}

async function getBotResponse(userMessage) {
    const apiUrl = `api.php?msg=${encodeURIComponent(userMessage)}`;

    try {
        const response = await fetch(apiUrl);
        const data = await response.json();
        return data.response || "Oops! Something went wrong. :(";
    } catch (error) {
        return "I couldn't connect to the chatbot. Please try again later.";
    }
}