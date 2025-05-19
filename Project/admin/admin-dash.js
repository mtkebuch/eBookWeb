document.addEventListener("DOMContentLoaded", function() {
  console.log('JS loaded');  // test
  var messageOverlay = document.querySelector('.message-overlay');

  if (messageOverlay) {
    setTimeout(function() {
      console.log('Fading out'); // test
      messageOverlay.classList.add('fade-out');  
      setTimeout(function() {
        messageOverlay.style.display = 'none';  
      }, 300); 
    }, 500); 
  }
});
