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

if (isset($_GET['visitID'])) {
    $visitID = $conn->real_escape_string($_GET['visitID']);

    // Delete the record from the post table
    $sql = "DELETE FROM post WHERE visitID = '$visitID'";
    if ($conn->query($sql) === TRUE) {
        // Optionally, delete the record from the visitRecord table as well
        $sql = "DELETE FROM visitRecord WHERE visitID = '$visitID'";
        if ($conn->query($sql) === TRUE) {
            header("Location: test.php");
            exit();
        } else {
            echo "Error deleting visit record: " . $conn->error;
        }
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "No visitID provided";
}

$conn->close();
?>