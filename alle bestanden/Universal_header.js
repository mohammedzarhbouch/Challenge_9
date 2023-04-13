const openPopupBtn = document.getElementById('open-popup');
const closePopupBtns = document.querySelectorAll('.popup button');
const popup = document.getElementById('popup');

openPopupBtn.addEventListener('click', function() {
  popup.style.display = 'block';
});

closePopupBtns.forEach(function(btn) {
  btn.addEventListener('click', function() {
    if (btn.id === 'yes-btn') {
      // Do something if user clicked 'Yes'
    }
    popup.style.display = 'none';
  });
});

// Close popup when clicking outside the popup box
window.addEventListener('click', function(event) {
  if (event.target === popup) {
    popup.style.display = 'none';
  }
});
