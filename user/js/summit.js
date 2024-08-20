// change page
function loadSchedule(page) {
  window.location.href = page;
}

document.getElementById('fileInput').addEventListener('change', function() {
  // You can handle the file selection here
  console.log(this.files[0].name);
});

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Get the form element
  var form = document.getElementById('summit-form');

  // Add an event listener for the 'submit' event
  form.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Get the redirect URL from the data-redirect-url attribute
    var redirectUrl = this.getAttribute('data-redirect-url');

    // Perform any desired form processing or validation here

    // Redirect the user to the specified URL
    window.location.href = redirectUrl;

    alert("submit successful!")
  });
});

// function submitForm(event) {
//   event.preventDefault(); // Prevent the default form submission behavior
  
//   // get the form element
//   var form = event.target;
  
//   // get the redirect url from the data-redirect-url attribute
//   var redirectUrl = form.getAttribute('data-redirect-url');
  
//   // perform any desired form processing or validation here
  
//   // redirect the user to the specified URL
//   window.location.href = redirectUrl;

//   alert("submit successful!")
// }