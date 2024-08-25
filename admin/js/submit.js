function loadSchedule(page) {
  window.location.href = page;
}

function sendWhatsAppMessage(phoneNumber, message) {
  // Construct the WhatsApp URL
  const whatsappUrl = `https://api.whatsapp.com/send?phone=${phoneNumber}&text=${encodeURIComponent(message)}`;

  // Create a new anchor element
  const link = document.createElement('a');
  link.href = whatsappUrl;
  link.target = '_blank'; // Open in a new tab/window

  // Append the link to the body
  document.body.appendChild(link);

  // Trigger a click event on the link
  link.click();

  // Remove the link from the DOM
  document.body.removeChild(link);
}