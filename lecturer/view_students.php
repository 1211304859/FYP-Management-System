<?php
session_start();
require_once '../includes/db_connect.php';
$conn = OpenCon();

// Check if logged-in user is a lecturer
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: ../auth/lecturer_login.php");
    exit();
}

$lecturer_id = $_SESSION['userid'];

// Updated query to fetch assigned students and their projects
$sql = "SELECT s.firstName, s.lastName, p.title, a.progress
        FROM assigned_fyp a
        JOIN student s ON a.studentid = s.studentid
        JOIN proposals p ON a.proposalid = p.proposalid
        WHERE a.lecturerid = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $lecturer_id);
$stmt->execute();
$result = $stmt->get_result();
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Assigned Students</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>FCI FYP Management System</h1>
    </header>
    <main>
        <div class="card">
            <h2>Assigned Students</h2>
            <?php if ($result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <strong>Name:</strong> <?php echo htmlspecialchars($row['firstName'] . " " . $row['lastName']); ?><br>
                            <strong>FYP Title:</strong> <?php echo htmlspecialchars($row['title']); ?><br>
                            <strong>Progress:</strong> <?php echo htmlspecialchars($row['progress']); ?>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No students assigned yet.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>

