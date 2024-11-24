function showSubmissions(userID, userName, submissions) {
    // Create the modal structure
    const modalHTML = `
    <div id="submissionModal" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
        <div class="content">
            <h1>${userName}'s Submissions</h1>
            <ul class="submission-list">
            ${submissions.map((submission, index) => `
                <li>
                <button onclick="showSubmissionDetails('${userID}', '${userName}', '${submission.postContent}', '${submission.postImage}', '${submission.jName}', '${submission.postTime}', ${submission.journeyID})">
                    Submission ${index + 1} - ${submission.postTime}
                </button>
                </li>
            `).join('')}
            </ul>
        </div>
        </div>
    </div>
    `;

    // Append the modal to the body
    document.body.insertAdjacentHTML('beforeend', modalHTML);

    // Get the modal
    const modal = document.getElementById("submissionModal");

    // Get the <span> element that closes the modal
    const span = modal.querySelector(".close");

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    modal.style.display = "none";
    modal.remove();
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
        modal.remove();
    }
    }

    // Display the modal
    modal.style.display = "block";
}

function showSubmissionDetails(userID, userName, postContent, postImage, jName, postTime, journeyID) {
    const detailsHTML = `
    <div class="content">
        <h1>${userName}'s Submission Details</h1>
        <p><strong>Journey:</strong> ${jName} (${journeyID})</p>
        <p><strong>Submission Time:</strong> ${postTime}</p>
        <p><strong>Content:</strong> ${postContent}</p>
        ${postImage ? `<p><strong>Image:</strong><br><img src="${postImage}" alt="Post Image"></p>` : ''}
    </div>
    `;

    // Get the modal content element
    const modalContent = document.querySelector("#submissionModal .modal-content");

    // Update the modal content with the details
    modalContent.innerHTML = `
    <span class="close">&times;</span>
    ${detailsHTML}
    `;

    // Get the <span> element that closes the modal
    const span = modalContent.querySelector(".close");

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
    const modal = document.getElementById("submissionModal");
    modal.style.display = "none";
    modal.remove();
    }
}

  // CSS for the modal
const style = document.createElement('style');
style.innerHTML = `
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0,0,0);
        background-color: rgba(0,0,0,0.4);
    }
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
    }
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }
    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
    .content img {
        max-width: 100%;
        border-radius: 10px;
    }
    .submission-list {
        list-style-type: none;
        padding: 0;
    }
    .submission-list li {
        margin-bottom: 10px;
    }
    .submission-list button {
        padding: 10px;
        font-size: 16px;
        cursor: pointer;
    }
`;
document.head.appendChild(style);

function loadSchedule(page) {
    window.location.href = page;
}