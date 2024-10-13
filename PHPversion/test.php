<?php
session_start();
if (!isset($_SESSION['userID'])) {
    header("Location: index.php");
    exit();
}

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

// Fetch submissions
$sql = "SELECT vr.userID, u.userName, vr.journeyID, p.postContent, p.postImage, p.postTime, p.visitID 
        FROM visitRecord vr 
        JOIN post p ON vr.visitID = p.visitID 
        JOIN user u ON vr.userID = u.userID 
        ORDER BY p.postTime DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View Submissions</title>
    <link rel="icon" type="image/x-icon" href="image/icon.ico">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/test.css">
    <link rel="stylesheet" href="css/darkMode.css">
</head>
<body>
    <div class="menu">
        <div class="logo">
            <a href="pages/home.php">
                <img src="image/logo.png" alt="Web Logo">
            </a>
        </div>
        <ul class="menu-items">
            <li><a href="schedule.php">Schedule</a></li>
            <li><a href="room.html">Room</a></li>
            <li><a href="chat.php">Chat</a></li>
            <li><a href="view_submissions.php">View Submissions</a></li>
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

    <div class="submissions-container">
        <h1>Submissions</h1>
        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>User Name</th>
                    <th>Journey ID</th>
                    <th>Post Content</th>
                    <th>Post Image</th>
                    <th>Post Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['userID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['userName']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['journeyID']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['postContent']) . "</td>";
                        echo "<td>";
                        if ($row['postImage']) {
                            echo "<img src='" . htmlspecialchars($row['postImage']) . "' alt='Post Image' style='max-width: 100px;'>";
                        }
                        echo "</td>";
                        echo "<td>" . htmlspecialchars($row['postTime']) . "</td>";
                        echo "<td><a href='testDelete.php?visitID=" . htmlspecialchars($row['visitID']) . "' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No submissions found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="js/darkMode.js" async defer></script>
</body>
</html>