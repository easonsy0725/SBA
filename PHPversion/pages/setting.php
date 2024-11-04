<?php
session_start();
if (!isset($_SESSION['userID']) || ($_SESSION['userRole'] != 'admin' && $_SESSION['userRole'] != 'teacher')) {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Settings</title>
</head>
<body>
    <h1>Admin Settings</h1>
    <ul>
        <li><a href="manageRoom.php">Manage Room</a></li>
        <li><a href="journeySet.php">Manage Journeys</a></li>
    </ul>
</body>
</html>