// change page
function loadSchedule(page) {
  window.location.href = page;
}

function openFileInput(inputId) {
  document.getElementById(inputId).click();
}

document.getElementById('fileInput1').addEventListener('change', function() {
  // You can handle the file selection here
  console.log(this.files[0].name);
});

document.getElementById('fileInput2').addEventListener('change', function() {
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
    // ...

    // Redirect the user to the specified URL
    window.location.href = redirectUrl;

    alert("Submit Successful");
  });

  // Add click event listeners to the "Take Photo" buttons
  var takePhotoButtons = document.querySelectorAll('.custom-button');
  takePhotoButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default button click behavior
      // Add your custom logic for handling the "Take Photo" button click here
    });
  });
});

function openFileInput(inputId) {
  document.getElementById(inputId).click();
}

function previewImage(event, previewId) {
  const preview = document.getElementById(previewId);
  preview.innerHTML = '<div class="delete-btn" onclick="deletePreview(\'' + previewId + '\')">x</div>';

  if (event.target.files.length > 0) {
    const file = event.target.files[0];
    const img = document.createElement('img');
    img.src = URL.createObjectURL(file);
    img.onload = function() {
      URL.revokeObjectURL(img.src);
    }
    preview.appendChild(img);
  }
}

function deletePreview(previewId) {
  const preview = document.getElementById(previewId);
  preview.innerHTML = '';
}

document.querySelectorAll('input[type="file"]').forEach(input => {
  input.addEventListener('change', (event) => {
    previewImage(event, `preview${event.target.id.slice(-1)}`);
  });
});

document.getElementById('photoForm').addEventListener('submit', (event) => {
  event.preventDefault();
  // Add your form submission logic here
  console.log('Form submitted');
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