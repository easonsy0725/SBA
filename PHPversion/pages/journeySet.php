<?php
session_start();
if (!isset($_SESSION['userID']) || ($_SESSION['userRole'] != 'admin' && $_SESSION['userRole'] != 'teacher')) {
    header("Location: ../index.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "eason070725sy";
$dbname = "sba";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['update'])) {
        $journeyID = $conn->real_escape_string($_POST['journeyID']);
        $newSchedule = $conn->real_escape_string($_POST['schedule']);
        $sql = "UPDATE journey SET jDescribe='$newSchedule' WHERE journeyID='$journeyID'";

        if ($conn->query($sql) === TRUE) {
            echo "Schedule updated successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['add'])) {
        $journeyID = $conn->real_escape_string($_POST['newJourneyID']);
        $jName = $conn->real_escape_string($_POST['newJourneyName']);
        $address = $conn->real_escape_string($_POST['newJourneyAddress']);
        $jDescribe = $conn->real_escape_string($_POST['newJourneyDescribe']);
        $sql = "INSERT INTO journey (journeyID, jName, address, jDescribe) VALUES ('$journeyID', '$jName', '$address', '$jDescribe')";

        if ($conn->query($sql) === TRUE) {
            echo "New journey added successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
        $journeyID = $conn->real_escape_string($_POST['deleteJourneyID']);
        
        // Delete related records in post table
        $sql = "DELETE FROM post WHERE visitID IN (SELECT visitID FROM visitRecord WHERE journeyID='$journeyID')";
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Delete related records in visitRecord table
        $sql = "DELETE FROM visitRecord WHERE journeyID='$journeyID'";
        if ($conn->query($sql) !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Delete the journey
        $sql = "DELETE FROM journey WHERE journeyID='$journeyID'";
        if ($conn->query($sql) === TRUE) {
            echo "Journey deleted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$sql = "SELECT journeyID, jName, jDescribe FROM journey";
$result = $conn->query($sql);
$journeys = [];
while ($row = $result->fetch_assoc()) {
    $journeys[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
</head>
<body>
    <h1>Admin Page</h1>
    <form method="POST" action="journeySet.php">
        <label for="journeyID">Select Journey:</label><br>
        <select id="journeyID" name="journeyID">
            <?php foreach ($journeys as $journey): ?>
                <option value="<?php echo htmlspecialchars($journey['journeyID']); ?>">
                    <?php echo htmlspecialchars($journey['jName']); ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <label for="schedule">Schedule Description:</label><br>
        <textarea id="schedule" name="schedule" rows="10" cols="50"></textarea><br>
        <button type="submit" name="update">Update Schedule</button>
    </form>

    <h2>Add New Journey</h2>
    <form method="POST" action="journeySet.php">
        <label for="newJourneyID">Journey ID:</label><br>
        <input type="text" id="newJourneyID" name="newJourneyID"><br>
        <label for="newJourneyName">Journey Name:</label><br>
        <input type="text" id="newJourneyName" name="newJourneyName"><br>
        <label for="newJourneyAddress">Journey Address:</label><br>
        <input type="text" id="newJourneyAddress" name="newJourneyAddress"><br>
        <label for="newJourneyDescribe">Journey Description:</label><br>
        <textarea id="newJourneyDescribe" name="newJourneyDescribe" rows="10" cols="50"></textarea><br>
        <button type="submit" name="add">Add Journey</button>
    </form>

    <h2>Delete Journey</h2>
    <form method="POST" action="journeySet.php">
        <label for="deleteJourneyID">Journey ID:</label><br>
        <input type="text" id="deleteJourneyID" name="deleteJourneyID"><br>
        <button type="submit" name="delete">Delete Journey</button>
    </form>
</body>
</html>