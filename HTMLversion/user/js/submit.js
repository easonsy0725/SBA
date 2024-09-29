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


// Change the page by redirecting the user to a new URL
function loadSchedule(page) {
  window.location.href = page;
}

// Open a file input by clicking on it programmatically
function openFileInput(inputId) {
  document.getElementById(inputId).click();
}

// Add an event listener to the first file input to handle file selection
document.getElementById('fileInput1').addEventListener('change', function() {
  console.log(this.files[0].name);
});

// Add an event listener to the second file input to handle file selection
document.getElementById('fileInput2').addEventListener('change', function() {
  console.log(this.files[0].name);
});

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
  // Get the form element
  var form = document.getElementById('summit-form');

  // Add an event listener for the 'submit' event on the form
  form.addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the default form submission behavior

    // Get the redirect URL from the data-redirect-url attribute
    var redirectUrl = this.getAttribute('data-redirect-url');

    // Redirect the user to the specified URL
    window.location.href = redirectUrl;

    alert("Submit Successful");
  });

  // Add click event listeners to the "Take Photo" buttons
  var takePhotoButtons = document.querySelectorAll('.custom-button');
  takePhotoButtons.forEach(function(button) {
    button.addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the default button click behavior
    });
  });
});

// Open a file input by clicking on it programmatically
function openFileInput(inputId) {
  document.getElementById(inputId).click();
}

// Preview an image selected in a file input
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

// Delete the preview of an image
function deletePreview(previewId) {
  const preview = document.getElementById(previewId);
  preview.innerHTML = '';
}

// Add event listeners for file input changes to preview images
document.querySelectorAll('input[type="file"]').forEach(input => {
  input.addEventListener('change', (event) => {
    previewImage(event, `preview${event.target.id.slice(-1)}`);
  });
});

// Add an event listener for the form submission
document.getElementById('photoForm').addEventListener('submit', (event) => {
  event.preventDefault();
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