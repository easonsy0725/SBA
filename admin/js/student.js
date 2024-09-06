document.querySelectorAll('.card').forEach(card => {
  card.addEventListener('click', (event) => {
      // Prevent event from bubbling up to the document
      event.stopPropagation();
      
      // Toggle the visibility of card content
      const cardContent = card.querySelector('.card__content');
      if (cardContent.style.transform === 'rotateX(0deg)') {
          cardContent.style.transform = 'rotateX(-90deg)';
      } else {
          cardContent.style.transform = 'rotateX(0deg)';
      }
  });
});

// Listen for clicks on the document
document.addEventListener('click', () => {
  // Hide all card content
  document.querySelectorAll('.card__content').forEach(cardContent => {
      cardContent.style.transform = 'rotateX(-90deg)';
  });
});