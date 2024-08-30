document.getElementById('resetForm').addEventListener('submit', function(event) {
  event.preventDefault();
  const email = document.getElementById('email').value;
  const messageDiv = document.getElementById('message');
  const passwordDiv = document.getElementById('password');

  // Basic email validation
  if (!validateEmail(email)) {
      messageDiv.textContent = "Please enter a valid email address.";
      messageDiv.style.color = "red";
      passwordDiv.textContent = "";
      passwordDiv.style.display = "none"; // Hide password
      return;
  }

  // Simulate checking the email (hardcoded example)
  if (email === "easonsy0725@gmail.com" || email === "s190072@cloud.sja.edu.hk") {
      messageDiv.textContent = "Email is valid!";
      messageDiv.style.color = "green";

      if (email === "s190072@cloud.sja.edu.hk") {
          passwordDiv.textContent = "Your password is: 'user'";
      } else {
          passwordDiv.textContent = "Your password is: 'admin'";
      }
      passwordDiv.style.display = "block"; // Show password

      // Hide the password after 3 seconds
      setTimeout(() => {
          passwordDiv.style.display = "none";
      }, 3000);
  } else {
      messageDiv.textContent = "Email not found.";
      messageDiv.style.color = "red";
      passwordDiv.textContent = "";
      passwordDiv.style.display = "none"; // Hide password
  }
});

// Login button at the top
document.getElementById('loginButtonTop').addEventListener('click', function() {
  // Redirect to the login page
  window.location.href = "../index.html"; // Change to your login page URL
});

function validateEmail(email) {
  const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
  return re.test(String(email).toLowerCase());
}