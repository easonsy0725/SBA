<?php
session_start();
if (!isset($_SESSION['userID']) || ($_SESSION['userRole'] != 'admin' && $_SESSION['userRole'] != 'teacher')) {
    header("Location: index.php");
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
    if (isset($_POST['assign'])) {
        $roomNum = $conn->real_escape_string($_POST['roomNum']);
        $user1 = $conn->real_escape_string($_POST['user1']);
        $user2 = !empty($_POST['user2']) ? $conn->real_escape_string($_POST['user2']) : NULL;

        // Fetch gender of the selected users
        $sql = "SELECT gender FROM user WHERE userID IN ('$user1', '$user2')";
        $result = $conn->query($sql);
        $genders = [];
        while ($row = $result->fetch_assoc()) {
            $genders[] = $row['gender'];
        }

        if (count($genders) == 2 && $genders[0] != $genders[1]) {
            echo "Error: Users must be of the same gender to be in the same room.";
        } else {
            // Check if users are already assigned to a room
            $checkSql = "SELECT roomNum FROM room WHERE user1='$user1' OR user2='$user1' OR user1='$user2' OR user2='$user2'";
            $checkResult = $conn->query($checkSql);

            if ($checkResult->num_rows > 0) {
                echo "Error: One or both users are already assigned to a room.";
            } else {
                // Insert or update the room assignment
                if ($user2) {
                    $sql = "INSERT INTO room (roomNum, user1, user2) VALUES ('$roomNum', '$user1', '$user2')
                            ON DUPLICATE KEY UPDATE user1='$user1', user2='$user2'";
                } else {
                    $sql = "INSERT INTO room (roomNum, user1) VALUES ('$roomNum', '$user1')
                            ON DUPLICATE KEY UPDATE user1='$user1'";
                }

                if ($conn->query($sql) === TRUE) {
                    echo "Room assignment updated successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            }
        }
    } elseif (isset($_POST['change'])) {
        $userID = $conn->real_escape_string($_POST['userID']);
        $newRoomNum = $conn->real_escape_string($_POST['newRoomNum']);
        $roommateID = !empty($_POST['roommateID']) ? $conn->real_escape_string($_POST['roommateID']) : NULL;

        // Check if the new room already has two users
        $checkSql = "SELECT COUNT(*) AS userCount FROM room WHERE roomNum='$newRoomNum'";
        $checkResult = $conn->query($checkSql);
        $row = $checkResult->fetch_assoc();
        if ($row['userCount'] >= 2) {
            echo "Error: The new room already has two users.";
        } else {
            // Remove user and their roommate from the current room
            $sql = "SELECT roomNum, user1, user2 FROM room WHERE user1='$userID' OR user2='$userID'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $currentRoomNum = $row['roomNum'];
                $user1 = $row['user1'];
                $user2 = $row['user2'];

                // Remove both users from the current room
                $sql = "DELETE FROM room WHERE roomNum='$currentRoomNum'";
                if ($conn->query($sql) === TRUE) {
                    // Add users to the new room
                    if ($roommateID) {
                        $sql = "INSERT INTO room (roomNum, user1, user2) VALUES ('$newRoomNum', '$userID', '$roommateID')
                                ON DUPLICATE KEY UPDATE user1='$userID', user2='$roommateID'";
                    } else {
                        $sql = "INSERT INTO room (roomNum, user1) VALUES ('$newRoomNum', '$userID')
                                ON DUPLICATE KEY UPDATE user1='$userID'";
                    }

                    if ($conn->query($sql) === TRUE) {
                        echo "User and their roommate moved to the new room successfully.";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: User not found in any room.";
            }
        }
    }
}

// Fetch all students and teachers
$sql = "SELECT userID, userName, userRole, gender FROM user";
$result = $conn->query($sql);
$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Rooms</title>
</head>
<body>
    <h1>Manage Rooms</h1>
    <form method="POST" action="manageRoom.php">
        <label for="roomNum">Room Number:</label><br>
        <input type="text" id="roomNum" name="roomNum" required><br>
        
        <label for="user1">Select User 1:</label><br>
        <select id="user1" name="user1" required>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo htmlspecialchars($user['userID']); ?>">
                    <?php echo htmlspecialchars($user['userName']); ?> (<?php echo htmlspecialchars($user['userRole']); ?>, <?php echo htmlspecialchars($user['gender']); ?>)
                </option>
            <?php endforeach; ?>
        </select><br>
        
        <label for="user2">Select User 2 (optional):</label><br>
        <select id="user2" name="user2">
            <option value="">None</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo htmlspecialchars($user['userID']); ?>">
                    <?php echo htmlspecialchars($user['userName']); ?> (<?php echo htmlspecialchars($user['userRole']); ?>, <?php echo htmlspecialchars($user['gender']); ?>)
                </option>
            <?php endforeach; ?>
        </select><br>
        
        <button type="submit" name="assign">Assign Room</button>
    </form>

    <h2>Change Room</h2>
    <form method="POST" action="manageRoom.php">
        <label for="userID">Select User:</label><br>
        <select id="userID" name="userID" required>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo htmlspecialchars($user['userID']); ?>">
                    <?php echo htmlspecialchars($user['userName']); ?> (<?php echo htmlspecialchars($user['userRole']); ?>, <?php echo htmlspecialchars($user['gender']); ?>)
                </option>
            <?php endforeach; ?>
        </select><br>
        
        <label for="newRoomNum">New Room Number:</label><br>
        <input type="text" id="newRoomNum" name="newRoomNum" required><br>
        
        <label for="roommateID">Select Roommate (optional):</label><br>
        <select id="roommateID" name="roommateID">
            <option value="">None</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo htmlspecialchars($user['userID']); ?>">
                    <?php echo htmlspecialchars($user['userName']); ?> (<?php echo htmlspecialchars($user['userRole']); ?>, <?php echo htmlspecialchars($user['gender']); ?>)
                </option>
            <?php endforeach; ?>
        </select><br>
        
        <button type="submit" name="change">Change Room</button>
    </form>
</body>
</html>