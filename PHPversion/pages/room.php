<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../index.php");
    exit();
}

$userRole = $_SESSION['userRole'];

$servername = "localhost";
$username = "root";
$password = "eason070725sy";
$dbname = "sba";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch room assignments
$sql = "SELECT room.roomNum, user1.userName AS user1Name, user1.gender AS user1Gender, user2.userName AS user2Name, user2.gender AS user2Gender
        FROM room
        LEFT JOIN user AS user1 ON room.user1 = user1.userID
        LEFT JOIN user AS user2 ON room.user2 = user2.userID";
$result = $conn->query($sql);
$rooms = [];
while ($row = $result->fetch_assoc()) {
    $rooms[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Room Assignments</title>
    <link rel="icon" type="image/x-icon" href="../image/icon.ico">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/room.css">
    <link rel="stylesheet" href="../css/darkMode.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>
<body>
    <div class="menu">
        <div class="logo">
            <a href="home.php">
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
    <h1>Room Assignments</h1>
    <div class="rooms">
        <?php foreach ($rooms as $room): ?>
            <div class="room">
                <h2 class="roomNum">Room <?php echo htmlspecialchars($room['roomNum']); ?></h2>
                <span class="teacher-box" data-gender="<?php echo htmlspecialchars($room['user1Gender']); ?>">
                    <?php echo htmlspecialchars($room['user1Name']); ?>
                </span>
                <?php if ($room['user2Name']): ?>
                    <span class="teacher-box" data-gender="<?php echo htmlspecialchars($room['user2Gender']); ?>">
                        <?php echo htmlspecialchars($room['user2Name']); ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="../js/darkMode.js"></script>
    
</body>
</html>