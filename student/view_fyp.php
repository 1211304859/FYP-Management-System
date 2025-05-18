<?php
session_start();
require_once '../includes/db_connect.php';

// Ensure the user is logged in as a student
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/student_login.php"); // Redirect to login
    exit();
}

$conn = OpenCon();
$studentid = $_SESSION['userid'];

// Fetch the assigned FYP project for the logged-in student
$sql = "SELECT proposals.title, proposals.description, assigned_fyp.progress AS status
        FROM assigned_fyp
        JOIN proposals ON assigned_fyp.proposalid = proposals.proposalid
        WHERE assigned_fyp.studentid = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $studentid);
$stmt->execute();
$result = $stmt->get_result();
$project = $result->fetch_assoc();

CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Assigned FYP</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>FCI FYP Management System</h1>
    </header>
    <main>
        <div class="card">
            <h2>Your FYP Project</h2>
            <?php if ($project): ?>
                <p><strong>Title:</strong> <?php echo htmlspecialchars($project['title']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($project['description']); ?></p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($project['status']); ?></p>
            <?php else: ?>
                <p style="color: red;">No FYP has been assigned to you yet.</p>
            <?php endif; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>

