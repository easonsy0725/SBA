const form = document.getElementById('login-form');
const messageElement = document.getElementById('message');

form.addEventListener('submit', (event) => {
  event.preventDefault(); // Prevent the default form submission

  const username = document.getElementById('username').value;
  const password = document.getElementById('password').value;

  if (username === 'admin' && password === 'admin') {
    messageElement.textContent = 'Login successful!';
    messageElement.classList.remove('error');
    messageElement.classList.add('success');

    // Redirect the admin user to the admin page
    window.location.href = 'admin/adminPage.html';
  } else if (username === 'user' && password === 'user') {
    messageElement.textContent = 'Login successful!';
    messageElement.classList.remove('error');
    messageElement.classList.add('success');

    // Redirect the normal user to the user page
    window.location.href = 'user/userPage.html';
  } else {
    messageElement.textContent = 'Login failed!';
    messageElement.classList.remove('success');
    messageElement.classList.add('error');

    // Show the message for 2 seconds and then hide it
    messageElement.style.display = 'block';
    setTimeout(() => {
      messageElement.style.display = 'none';
    }, 2000);
  }
});