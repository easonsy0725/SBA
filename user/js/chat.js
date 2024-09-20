document.addEventListener('DOMContentLoaded', function() {
  const chatBox = document.getElementById('chat-box');
  const messageInput = document.getElementById('message-input');
  const sendButton = document.getElementById('send-button');

  sendButton.addEventListener('click', function() {
      const message = messageInput.value.trim();
      if (message !== '') {
          addMessageToChatBox('You', message);
          messageInput.value = '';
          // Simulate receiving a reply
          setTimeout(() => {
              addMessageToChatBox('Bot', 'This is a reply.');
          }, 1000);
      }
  });

  messageInput.addEventListener('keypress', function(event) {
      if (event.key === 'Enter') {
          sendButton.click();
      }
  });

  function addMessageToChatBox(sender, message) {
      const messageElement = document.createElement('div');
      messageElement.classList.add('message');
      messageElement.innerHTML = `<strong>${sender}:</strong> ${message}`;
      chatBox.appendChild(messageElement);
      chatBox.scrollTop = chatBox.scrollHeight;
  }
});