<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "eason070725sy";
    $dbname = "sba";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $loginUsername = $conn->real_escape_string($_POST['username']);
    $loginPassword = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT userID, userRole FROM user WHERE username='$loginUsername' AND password='$loginPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['userID'] = $row['userID'];
        $_SESSION['userRole'] = $row['userRole'];

        header("Location: pages/home.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }

    $conn->close();
}
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
        <form class="login-form" id="login-form" action="index.php" method="post">
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
        <?php if (isset($error)): ?>
            <div id="message" class="message"><?php echo $error; ?></div>
        <?php endif; ?>
    </div>
    <!-- <script src="js/script.js" async defer></script> -->
</body>
</html>