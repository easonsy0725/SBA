<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: ../index.php");
    exit();
}

$userID = $_SESSION['userID'];
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $journeyIDs = [301, 302]; // Adjust journey IDs based on the day
    foreach ($journeyIDs as $index => $journeyID) {
        $visitID = $userID . $journeyID;
        $postContent = $conn->real_escape_string($_POST['comment' . ($index + 1)]);
        $postImage = '';

        if (isset($_FILES['image' . ($index + 1)]) && $_FILES['image' . ($index + 1)]['error'] == 0) {
            $targetDir = "../../uploads/";
            $targetFile = $targetDir . basename($_FILES['image' . ($index + 1)]['name']);
            if (move_uploaded_file($_FILES['image' . ($index + 1)]['tmp_name'], $targetFile)) {
                $postImage = $targetFile;
            } else {
                echo "Error uploading file: " . $_FILES['image' . ($index + 1)]['error'];
                exit();
            }
        }

        // Check if visitID exists in visitRecord table
        $checkVisitID = "SELECT visitID FROM visitRecord WHERE visitID = '$visitID'";
        $visitResult = $conn->query($checkVisitID);

        if ($visitResult->num_rows == 0) {
            // Insert into visitRecord table if visitID does not exist
            $insertVisitRecord = "INSERT INTO visitRecord (visitID, userID, journeyID, visitTime) VALUES ('$visitID', '$userID', '$journeyID', NOW())";
            if ($conn->query($insertVisitRecord) !== TRUE) {
                echo "Error: " . $insertVisitRecord . "<br>" . $conn->error;
                exit();
            }
        }

        // Insert into post table
        $sql = "INSERT INTO post (visitID, postTime, postContent, postImage) VALUES ('$visitID', NOW(), '$postContent', '$postImage')";
        if ($conn->query($sql) === TRUE) {
            $message = "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
            exit();
        }
    }
    header("Location: ../schedule.php");
    exit();
}

$conn->close();
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Submit</title>
    <link rel="icon" type="image/x-icon" href="../../image/icon.ico">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/submit.css">
    <link rel="stylesheet" href="../../css/darkMode.css">
</head>
<body>
    <div class="menu">
        <div class="logo">
            <a href="../home.php">
                <img src="../../image/logo.png" alt="Web Logo">
            </a>
        </div>
        <ul class="menu-items">
            <?php if ($userRole == 'teacher' or $userRole == 'admin'): ?>
                <li><a href="../schedule.php">Schedule</a></li>
                <li><a href="../room.php">Room</a></li>
                <li><a href="../submission.php">Submit</a></li>
                <li><a href="../chat.php">Chat</a></li>
                <li><a href="../setting.php">Settings</a></li>
            <?php elseif ($userRole == 'test'): ?>
                <li><a href="../schedule.php">Schedule</a></li>
                <li><a href="../room.php">Room</a></li>
                <li><a href="../chat.php">Chat</a></li>
                <li><a href="../../test.php">test</a></li>
                <li><a href="../submit.php">Submit</a></li>
            <?php else: ?>
                <li><a href="../schedule.php">Schedule</a></li>
                <li><a href="../room.php">Room</a></li>
                <li><a href="../chat.php">Chat</a></li>
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

    <div class="dateSelecter">
        <button onclick="loadSchedule('../submit.php')">11</button>
        <button onclick="loadSchedule('day2.php')">12</button>
        <button onclick="loadSchedule('day3.php')">13</button>
        <button onclick="loadSchedule('day4.php')">14</button>
        <button onclick="loadSchedule('day5.php')">15</button>
    </div>

    <div class="submit-form">
        <div class="card">
            <span class="title">Day 3</span>
            <form class="form" id="submit-form" action="day3.php" method="post" enctype="multipart/form-data">
                <div class="group">
                    <input type="file" id="fileInput1" name="image1" accept="image/*" capture="camera">
                    <button class="custom-button" type="button" onclick="openFileInput('fileInput1');">Take Photo For Journey 1</button>
                    <div class="preview" id="preview1"></div>
                    <div class="delete-btn" onclick="deletePreview('preview1')"></div>
                </div>

                <div class="group">
                    <textarea placeholder="" id="comment1" name="comment1" rows="5"></textarea>
                    <label class="journey" for="comment1">Comment For Journey 1</label>
                </div>

                <div class="group">
                    <input type="file" id="fileInput2" name="image2" accept="image/*" capture="camera">
                    <button class="custom-button" type="button" onclick="openFileInput('fileInput2');">Take Photo For Journey 2</button>
                    <div class="preview" id="preview2"></div>
                    <div class="delete-btn" onclick="deletePreview('preview2')"></div>
                </div>

                <div class="group">
                    <textarea placeholder="" id="comment2" name="comment2" rows="5"></textarea>
                    <label class="journey" for="comment2">Comment For Journey 2</label>
                </div>

                <button type="submit" id="submitButton">Submit</button>
            </form>
        </div>
    </div>

    <script src="../../js/darkMode.js" async defer></script>
    <script src="../../js/submit.js" async defer></script>
</body>
</html>