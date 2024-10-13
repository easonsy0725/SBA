<?php
    session_start();
    if (!isset($_SESSION['userID'])) {
        header("Location: ../index.php");
        exit();
    }

    $userRole = $_SESSION['userRole'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <link rel="apple-touch-icon" href="../image/small_icon.ico">
    <link rel="icon" type="image/x-icon" href="../image/small_icon.ico">
    <link rel="stylesheet" href="../css/home.css">
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
                <li><a href="submit.php">Submit</a></li>
                <li><a href="chat.php">Chat</a></li>
            <?php else: ?>
                <li><a href="schedule.php">Schedule</a></li>
                <li><a href="room.html">Room</a></li>
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

    <div class="weather-section">
        <h2>Today's Weather in Tokyo, Japan</h2>
        <div class="weather-container">
            <div class="weather-icon">
                <i class="fas fa-sun"></i>
            </div>
            <div class="weather-details">
                <p id="weather-description"></p>
                <div class="weather-metrics">
                    <div class="weather-metric">
                        <i class="fas fa-thermometer-half"></i>
                        <p id="weather-temperature"></p>
                    </div>
                    <div class="weather-metric">
                        <i class="fas fa-wind"></i>
                        <p id="weather-wind"></p>
                    </div>
                    <div class="weather-metric">
                        <i class="fas fa-tint"></i>
                        <p id="weather-humidity"></p>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <script src="../js/darkMode.js" async defer></script>
    <script src="../js/home.js" async defer></script>
</body>
</html>