document.addEventListener('DOMContentLoaded', function() {
    // Get references to the chat box, message input, and send button elements
    const chatBox = document.getElementById('chat-box');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
  
    // Add an event listener to the send button to handle sending messages
    sendButton.addEventListener('click', function() {
        // Get the trimmed value of the message input
        const message = messageInput.value.trim();
        // Check if the message is not empty
        if (message !== '') {
            // Add the message to the chat box
            addMessageToChatBox('You', message);
            // Clear the message input
            messageInput.value = '';
            // Simulate receiving a reply after 1 second
            setTimeout(() => {
                addMessageToChatBox('Bot', 'This is a reply.');
            }, 1000);
        }
    });
  
    // Add an event listener to the message input to handle pressing the Enter key
    messageInput.addEventListener('keypress', function(event) {
        // Check if the pressed key is Enter
        if (event.key === 'Enter') {
            // Trigger the click event on the send button
            sendButton.click();
        }
    });
  
    // Function to add a message to the chat box
    function addMessageToChatBox(sender, message) {
        // Create a new div element for the message
        const messageElement = document.createElement('div');
        // Add the 'message' class to the message element
        messageElement.classList.add('message');
        // Set the inner HTML of the message element with the sender and message
        messageElement.innerHTML = `<strong>${sender}:</strong> ${message}`;
        // Append the message element to the chat box
        chatBox.appendChild(messageElement);
        // Scroll the chat box to the bottom
        chatBox.scrollTop = chatBox.scrollHeight;
    }
  });