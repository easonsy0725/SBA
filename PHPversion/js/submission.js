function showSubmissions(userID, userName, submissions) {
  // Determine the width and height based on the device's screen size
  const width = Math.min(window.innerWidth * 0.8, 600);
  const height = Math.min(window.innerHeight * 0.8, 400);

  // Open a new popup window with the calculated dimensions
  const popup = window.open('', '_blank', `width=${width},height=${height},scrollbars=yes,resizable=yes`);

  // Write the HTML content to the popup window
  popup.document.write(`
      <!DOCTYPE html>
      <html>
      <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>${userName}'s Submissions</title>
          <style>
              body {
                  font-family: Arial, sans-serif;
                  margin: 0;
                  padding: 20px;
                  box-sizing: border-box;
              }
              .content {
                  max-width: 100%;
                  margin: 0 auto;
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
          </style>
      </head>
      <body>
          <div class="content">
              <h1>${userName}'s Submissions</h1>
              <ul class="submission-list">
                  ${submissions.map((submission, index) => `
                      <li>
                          <button onclick="showSubmissionDetails('${userID}', '${userName}', '${submission.postContent}', '${submission.postImage}', '${submission.jName}', '${submission.postTime}')">
                              Submission ${index + 1} - ${submission.postTime}
                          </button>
                      </li>
                  `).join('')}
              </ul>
          </div>
          <script>
              function showSubmissionDetails(userID, userName, postContent, postImage, jName, postTime) {
                  const detailsPopup = window.open('', '_blank', 'width=${width},height=${height},scrollbars=yes,resizable=yes');
                  detailsPopup.document.write(\`
                      <!DOCTYPE html>
                      <html>
                      <head>
                          <meta charset="utf-8">
                          <meta name="viewport" content="width=device-width, initial-scale=1">
                          <title>\${userName}'s Submission Details</title>
                          <style>
                              body {
                                  font-family: Arial, sans-serif;
                                  margin: 0;
                                  padding: 20px;
                                  box-sizing: border-box;
                              }
                              .content {
                                  max-width: 100%;
                                  margin: 0 auto;
                              }
                              .content img {
                                  max-width: 100%;
                                  border-radius: 10px;
                              }
                          </style>
                      </head>
                      <body>
                          <div class="content">
                              <h1>\${userName}'s Submission Details</h1>
                              <p><strong>Journey:</strong> \${jName}</p>
                              <p><strong>Submission Time:</strong> \${postTime}</p>
                              <p><strong>Content:</strong> \${postContent}</p>
                              \${postImage ? \`<p><strong>Image:</strong><br><img src="\${postImage}" alt="Post Image"></p>\` : ''}
                          </div>
                      </body>
                      </html>
                  \`);
                  detailsPopup.document.close();
              }
          </script>
      </body>
      </html>
  `);
  popup.document.close();
}

function loadSchedule(page) {
    window.location.href = page;
}