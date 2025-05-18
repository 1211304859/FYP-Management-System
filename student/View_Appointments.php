<?php
session_start();
require_once '../includes/db_connect.php';
$conn = OpenCon();

// Check if user is logged in as a student
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/student_login.php");
    exit();
}

$student_id = $_SESSION['userid'];

// Fetch appointments for the student
$sql = "SELECT a.appointment_date, a.status, l.firstName AS lecturer_name 
        FROM appointments a 
        JOIN lecturer l ON a.lecturerid = l.lecturerid 
        WHERE a.studentid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Appointments</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Your Appointments</h1>
        <button class="logout-button" onclick="location.href='../auth/logout.php'">Logout</button>
    </header>
    <main>
        <div class="container">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Lecturer Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td><?php echo htmlspecialchars($row['lecturer_name']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No appointments found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
