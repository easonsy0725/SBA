//                     _____
//                    |     |
//                    |     |
//                    |     |
//    ________________|     |________________
//   |                                       |
//   |________________       ________________|
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |      |
//                    |______|

//                耶穌保佑† 唔好有BUG!!!


const form = document.getElementById('login-form');

document.getElementById('login-form').addEventListener('submit', function(event) {
  event.preventDefault(); 

  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;

  // Set a timeout to simulate loading for successful login
  setTimeout(() => {
    const successModal = document.getElementById('successModal');
    const modalMessage = document.getElementById('modalMessage');
    const modalButton = document.getElementById('modalButton');

    if ((username === 'user' && password === 'user123') || (username === 'admin' && password === 'admin')) {
      document.getElementById('loading').style.display = 'flex'; // Show the loader for successful login

      if (username === 'user') {
        modalMessage.textContent = 'Login successful - Redirecting to User Page';
        modalButton.onclick = function() {
          document.getElementById('loading').style.display = 'none'; // Hide the loader
          window.location.href = 'user/userPage.html';
        };
      } else {
        modalMessage.textContent = 'Login successful - Redirecting to Admin Page';
        modalButton.onclick = function() {
          document.getElementById('loading').style.display = 'none'; // Hide the loader
          window.location.href = 'admin/adminPage.html';
        };
      }
      successModal.style.display = 'flex'; // Show the modal
    } else {
      // For invalid login, show the error message without loader
      document.getElementById('loading').style.display = 'none'; // Ensure loader is hidden
      modalMessage.textContent = 'Invalid username or password. Please try again.';
      modalButton.onclick = function() {
        successModal.style.display = 'none'; // Hide the modal
      };
      successModal.style.display = 'flex'; // Show the modal
    }
  }, 100); // Delay to simulate loading
});