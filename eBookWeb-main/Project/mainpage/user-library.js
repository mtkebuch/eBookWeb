document.addEventListener("DOMContentLoaded", function() {
  var messageOverlay = document.querySelector('.message-overlay');

  if (messageOverlay) {
    setTimeout(function() {
      messageOverlay.classList.add('fade-out');  
      setTimeout(function() {
        messageOverlay.style.display = 'none';  
      }, 300); 
    }, 500);  
  }

  const stars = document.querySelectorAll('.star');
  let selectedRating = 0;


  stars.forEach(star => {
    star.addEventListener('click', function() {
      selectedRating = parseInt(this.getAttribute('data-rating'));
      stars.forEach(s => s.classList.remove('selected')); 
      for (let i = 0; i < selectedRating; i++) {
        stars[i].classList.add('selected'); 
      }
    });


    star.addEventListener('mouseover', function() {
      const rating = parseInt(this.getAttribute('data-rating'));
      stars.forEach(s => s.classList.remove('hovered')); 
      for (let i = 0; i < rating; i++) {
        stars[i].classList.add('hovered'); 
      }
    });

   
    star.addEventListener('mouseout', function() {
      stars.forEach(s => s.classList.remove('hovered')); 
      for (let i = 0; i < selectedRating; i++) {
        stars[i].classList.add('selected'); 
      }
    });
  });


  const ratingInput = document.createElement('input');
  ratingInput.type = 'hidden';
  ratingInput.name = 'rating';
  document.querySelector('.rating-form-global').appendChild(ratingInput);

  document.querySelector('.rating-form-global').addEventListener('submit', function() {
    ratingInput.value = selectedRating;
  });
});

document.querySelector('.rate-link').addEventListener('click', function(e) {
  e.preventDefault();
  document.querySelector('.star-rating').scrollIntoView({ behavior: 'smooth', block: 'start' });
});
