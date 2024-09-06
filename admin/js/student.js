// In student.js
document.querySelectorAll('.card').forEach(card => {
  card.addEventListener('click', () => {
      // Remove 'active' class from all cards
      document.querySelectorAll('.card').forEach(c => c.classList.remove('active'));
      // Add 'active' class to the clicked card
      card.classList.toggle('active');
  });
});