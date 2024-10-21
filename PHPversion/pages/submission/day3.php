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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$day = isset($_GET['day']) ? intval($_GET['day']) : 3;

$journeys = [
    1 => ['101', '102'],
    2 => ['201', '202'],
    3 => ['301', '302'],
    4 => ['401', '402', '403'],
    5 => ['501', '502']
];

// Fetch all students and their submission statuses
$journeyIDs = implode("','", $journeys[$day]);
$sql = "SELECT user.userID, user.userName, post.postContent, post.postImage, post.postTime, journey.jName, visitRecord.journeyID
        FROM user
        LEFT JOIN visitRecord ON user.userID = visitRecord.userID
        LEFT JOIN post ON visitRecord.visitID = post.visitID
        LEFT JOIN journey ON visitRecord.journeyID = journey.journeyID
        WHERE user.userRole = 'student' AND visitRecord.journeyID IN ('$journeyIDs')
        ORDER BY post.postTime DESC";
$result = $conn->query($sql);

$submitted = [];
$missing = [];

// Fetch all students
$allStudentsSql = "SELECT userID, userName FROM user WHERE userRole = 'student'";
$allStudentsResult = $conn->query($allStudentsSql);
$allStudents = [];
if ($allStudentsResult->num_rows > 0) {
    while ($row = $allStudentsResult->fetch_assoc()) {
        $allStudents[$row['userID']] = $row['userName'];
    }
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if ($row['postContent']) {
            $submitted[$row['journeyID']][$row['userID']][] = $row;
        }
    }
}

// Determine missing students
foreach ($allStudents as $userID => $userName) {
    $missingJourneys = [];
    foreach ($journeys[$day] as $journeyID) {
        if (!isset($submitted[$journeyID][$userID])) {
            $missingJourneys[] = $journeyID;
        }
    }
    if (!empty($missingJourneys)) {
        $missing[$userID] = ['userName' => $userName, 'journeys' => $missingJourneys];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Schedule</title>
    <link rel="icon" type="image/x-icon" href="../../image/icon.ico">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../css/submission.css">
    <link rel="stylesheet" href="../../css/darkMode.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
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
            <?php elseif ($userRole == 'test'): ?>
                <li><a href="../schedule.php">Schedule</a></li>
                <li><a href="../room.php">Room</a></li>
                <li><a href="../chat.php">Chat</a></li>
                <li><a href="../../test.php">test</a></li>
                <li><a href="../submission.php">Submit</a></li>
            <?php else: ?>
                <li><a href="../schedule.php">Schedule</a></li>
                <li><a href="../room.html">Room</a></li>
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
        <button onclick="loadSchedule('../submission.html')">11</button>
        <button onclick="loadSchedule('day2.php')">12</button>
        <button onclick="loadSchedule('day3.php')">13</button>
        <button onclick="loadSchedule('day4.php')">14</button>
        <button onclick="loadSchedule('day5.php')">15</button>
    </div>

    <h1>Day <?php echo $day; ?></h1>

    <div class="submit-container">
        <?php foreach ($submitted as $journeyID => $students): ?>
            <div class="submittedBox" id="box<?php echo $journeyID; ?>">
                <h2>Submitted for Journey <?php echo htmlspecialchars($students[array_key_first($students)][0]['jName']); ?></h2>
                <ul class="studentSubmission" style="list-style-type:none;">
                    <?php foreach ($students as $userID => $submissions): ?>
                        <li>
                            <button onclick="showSubmissions('<?php echo $userID; ?>', '<?php echo addslashes($submissions[0]['userName']); ?>', <?php echo htmlspecialchars(json_encode($submissions)); ?>)">
                                <?php echo htmlspecialchars($submissions[0]['userName']); ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>

        <div class="missingBox">
            <h2>Missing Submissions</h2>
            <ul class="studentMissing" style="list-style-type:none;">
                <?php foreach ($missing as $userID => $student): ?>
                    <li>
                        <button>
                            <?php echo htmlspecialchars($student['userName']); ?> - Missing Journeys: <?php echo implode(', ', $student['journeys']); ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <script src="../../js/darkMode.js" async defer></script>
    <script src="../../js/submission.js" async defer></script>
</body>
</html>
<?php
$conn->close();
?>