<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>        
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <link rel="apple-touch-icon" href="image/small_icon.ico">
        <link rel="icon" type="image/x-icon" href="image/small_icon.ico">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
      <div class="login-container">
          <form class="login-form" id="login-form" method="POST" action="">
            <p class="title">Login</p>
            <div class="input-field">
              <input required="" class="input" id="username" name="username" type="text" />
              <label class="label" for="username">Enter Username</label>
            </div>
            <div class="input-field">
              <input required="" class="input" id="password" name="password" type="password" />
              <label class="label" for="password">Enter Password</label>
            </div>
            <a href="html/password.html">Forgot your password?</a>
            <button type="submit" class="submit">Login</button>
          </form>
          <div id="message" class="message"></div>

          <div class="loader" id="loading">
            <div class="loader-text">Loading...</div>
            <div class="loader-bar"></div>
          </div>            
        </div>

        <div id="successModal" class="modal">
          <div class="modal-content">
            <p id="modalMessage"></p>
            <button id="modalButton">Continue</button>
          </div>
        </div>
      </div>

      <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "root";
            $password = "eason070725sy";
            $dbname = "sba";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Get the submitted username and password
            $submittedUsername = $_POST['userName'];
            $submittedPassword = $_POST['password'];

            // Prepare and bind
            $statement = $conn->prepare("SELECT userRole FROM user WHERE userName = ? AND password = ?");
            $statement->bind_param("ss", $submittedUsername, $submittedPassword);

            // Execute the statement
            $statement->execute();

            // Bind result variables
            $statement->bind_result($userRole);

            // Fetch the result
            if ($stmt->fetch()) {
                if ($userRole == 'student') {
                    header("Location: user/userPage.html");
                } elseif ($userRole == 'teacher') {
                    header("Location: admin/adminPage.html");
                }
                exit();
            } else {
                echo "<div id='message' class='message'>Invalid username or password</div>";
            }

            // Close the statement and connection
            $stmt->close();
            $conn->close();
        }
      ?>

        <script src="js/script.js" async defer></script>
    </body>
</html>