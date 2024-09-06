document.querySelectorAll('.card').forEach(card => {
  card.addEventListener('click', (event) => {
      // Prevent event from bubbling up to the document
      event.stopPropagation();
      
      // Remove 'active' class from all cards
      document.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
      
      // Toggle 'active' class on the clicked card
      card.classList.toggle('active');
  });
});

// Listen for clicks on the document
document.addEventListener('click', () => {
  // Remove 'active' class from all cards
  document.querySelectorAll('.card').forEach(card => {
      card.classList.remove('active');
  });
});