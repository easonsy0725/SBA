// Add event listener to the reset form submission
document.getElementById('resetForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the default form submission behavior

  const email = document.getElementById('email').value; // Get the email input value
  const messageDiv = document.getElementById('message'); // Get the message div element
  const passwordDiv = document.getElementById('password'); // Get the password div element

  // email validation
  if (!validateEmail(email)) {
      messageDiv.textContent = "Please enter a valid email address."; // Show error message
      messageDiv.style.color = "red"; // Set message color to red
      passwordDiv.textContent = ""; // Clear password text
      passwordDiv.style.display = "none"; // Hide password div
      return; // Exit the function
  }

  // checking the email (hardcode)
  if (email === "easonsy0725@gmail.com" || email === "s190072@cloud.sja.edu.hk") {
      messageDiv.textContent = "Email is valid!"; // Show success message
      messageDiv.style.color = "green"; // Set message color to green

      // Display the correct password based on the email
      if (email === "s190072@cloud.sja.edu.hk") {
          passwordDiv.textContent = "Your password is: 'user123'";
      } else {
          passwordDiv.textContent = "Your password is: 'admin'";
      }
      passwordDiv.style.display = "block"; // Show password div

      // Hide the password after 3 seconds
      setTimeout(() => {
          passwordDiv.style.display = "none";
      }, 3000);
  } else {
      messageDiv.textContent = "Email not found."; // Show error message
      messageDiv.style.color = "red"; // Set message color to red
      passwordDiv.textContent = ""; // Clear password text
      passwordDiv.style.display = "none"; // Hide password div
  }
});

// Add event listener to the login button at the top
document.getElementById('loginButtonTop').addEventListener('click', function() {
  // Redirect to the login page
  window.location.href = "../index.html"; // Change to your login page URL
});

// Function to validate email format
function validateEmail(email) {
  const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/; // Regular expression for email validation
  return re.test(String(email).toLowerCase()); // Test the email against the regex
}