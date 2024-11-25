<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../index.php");
    exit();
}

$userRole = $_SESSION['userRole'];
$isAdmin = isset($userRole) && $userRole == 'teacher' || $userRole == 'admin';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $servername = "localhost";
    $username = "root";
    $password = "eason070725sy";
    $dbname = "sba";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST['delete']) && $isAdmin) {
        $userID = $conn->real_escape_string($_POST['userID']);
        $sendTime = $conn->real_escape_string($_POST['sendTime']);
        $sql = "DELETE FROM chat WHERE userID='$userID' AND sendTime='$sendTime'";

        if ($conn->query($sql) === TRUE) {
            echo "Message deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    if (isset($_POST['send'])) {
        $userID = $_SESSION['userID'];
        $message = $conn->real_escape_string($_POST['message']);
        $image = '';

        if (!empty($_FILES['image']['name'])) {
            $image = '../../image/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image);
        }

        if (!empty($message) || !empty($image)) {
            $sql = "INSERT INTO chat (userID, sendTime, message, image) VALUES ('$userID', NOW(), '$message', '$image')";

            if ($conn->query($sql) === TRUE) {
                echo "New message sent successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    $conn->close();
    header("Location: chat.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Chat</title>
    <link rel="icon" type="image/x-icon" href="../image/icon.ico">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="stylesheet" href="../css/darkMode.css">
</head>
<body>
    <div class="menu">
        <div class="logo">
            <a href="home">
                <img src="../image/logo.png" alt="Web Logo">
            </a>
        </div>
        <ul class="menu-items">
            <?php if ($userRole == 'teacher'): ?>
                <li><a href="schedule.php">Schedule</a></li>
                <li><a href="room.php">Room</a></li>
                <li><a href="submission.php">Submit</a></li>
                <li><a href="chat.php">Chat</a></li>
            <?php elseif ($userRole == 'test' or $userRole == 'admin'): ?>
                <li><a href="schedule.php">Schedule</a></li>
                <li><a href="room.php">Room</a></li>
                <li><a href="chat.php">Chat</a></li>
                <li><a href="../test.php">test</a></li>
                <li><a href="submission.php">Submit</a></li>
                <li><a href="setting.php">Settings</a></li>
            <?php else: ?>
                <li><a href="schedule.php">Schedule</a></li>
                <li><a href="room.php">Room</a></li>
                <li><a href="chat.php">Chat</a></li>
            <?php endif; ?>
        </ul>
    </div>

    <div class="modeContainer">
        <label class="modeToggle" for="modeSwitch">
            <input id="modeSwitch" class="modeInput" type="checkbox">
            <div class="modeIcon icon--moon">
                <svg height="32" width="32" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" d="M9.528 1.718a.75.75 0 01.162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 01.981.98 10.503 10.503 0 01-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 01.818.162z" fill-rule="evenodd"></path>
                </svg>
            </div>
            <div class="modeIcon icon--sun">
                <svg height="32" width="32" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM7.5 12a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM18.894 6.166a.75.75 0 00-1.06-1.06l-1.591 1.59a.75.75 0 101.06 1.061l1.591-1.59zM21.75 12a.75.75 0 01-.75.75h-2.25a.75.75 0 010-1.5H21a.75.75 0 01.75.75zM17.834 18.894a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 10-1.061 1.06l1.59 1.591zM12 18a.75.75 0 01.75.75V21a.75.75 0 01-1.5 0v-2.25A.75.75 0 0112 18zM7.758 17.303a.75.75 0 00-1.061-1.06l-1.591 1.59a.75.75 0 001.06 1.061l1.591-1.59zM6 12a.75.75 0 01-.75.75H3a.75.75 0 010-1.5h2.25A.75.75 0 016 12zM6.697 7.757a.75.75 0 001.06-1.06l-1.59-1.591a.75.75 0 00-1.061 1.06l1.59 1.591z"></path>
                </svg>
            </div>
        </label>
    </div>

    <div class="announcement">
        <strong>Announcement:</strong> This is an important announcement. Please read carefully!
    </div>

    <div class="chat-container">
        <div class="chat-box" id="chat-box">
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "eason070725sy";
                $dbname = "sba";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT chat.userID, chat.sendTime, chat.message, chat.image, user.userName 
                    FROM chat 
                    JOIN user ON chat.userID = user.userID 
                    ORDER BY chat.sendTime ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="message">';
                    echo '<strong>' . htmlspecialchars($row['userName']) . ':</strong> ' . htmlspecialchars($row['message']);
                    if (!empty($row['image'])) {
                        echo ' <img src="' . htmlspecialchars($row['image']) . '" alt="Image">';
                    }
                    if ($isAdmin) {
                        echo '<form action="chat.php" method="post" style="display:inline;">
                                <input type="hidden" name="userID" value="' . $row['userID'] . '">
                                <input type="hidden" name="sendTime" value="' . $row['sendTime'] . '">
                                <button type="submit" name="delete" class="delete-button">Delete</button>
                              </form>';
                    }
                    echo '</div>';
                }
            } else {
                echo "No messages.";
            }

            $conn->close();
            ?>
        </div>
        <div class="chat-input">
            <form action="chat.php" method="post" enctype="multipart/form-data">
                <input type="text" name="message" placeholder="Type a message...">
                <input type="file" name="image">
                <button type="submit" name="send">Send</button>
            </form>
        </div>
    </div>

    <script src="../js/darkMode.js" async defer></script>
</body>
</html>