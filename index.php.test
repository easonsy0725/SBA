<?php
// Start the session
session_start();

// Database connection details
$serverName = "localhost";
$username = "root";
$password = "070725";
$database = "sba";

// Create connection
$conn = new mysqli($serverName, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $inputUsername = $_POST["userName"];
    $inputPassword = $_POST["password"];

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE userName = ?");
    $stmt->bind_param("s", $inputUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and the password is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($inputPassword, $row["password"])) {
            // Set the session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["username"] = $row["userName"];
            $_SESSION["userRole"] = $row["userRole"];

            // Redirect the user based on their role
            if ($row["userRole"] == "teacher") {
                header("location: admin/adminPage.html");
                exit;
            } elseif ($row["userRole"] == "student") {
                header("location: user/userPage.html");
                exit;
            } else {
                $error_message = "Invalid user role.";
            }
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "Invalid username or password.";
    }

    $stmt->close();
}

$conn->close();
?>

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
            <h2>Login</h2>
            <?php if (isset($error_message)) { ?>
                <div id="message" class="message" style="color: red;"><?php echo $error_message; ?></div>
            <?php } ?>
            <form id="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="userName">Username:</label>
                <input type="text" id="userName" name="userName" placeholder="Enter your username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <button type="submit" name="submit">Login</button>
            </form>
        </div>
        
        <script src="js/script.js" async defer></script>
    </body>
</html>