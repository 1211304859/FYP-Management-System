<?php
session_start();
require_once '../includes/db_connect.php';
$conn = OpenCon();

if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: ../auth/lecturer_login.php");
    exit();
}

$lecturer_id = $_SESSION['userid'];

// Handle Approve/Reject Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['appointment_id'], $_POST['action'])) {
    $appointment_id = $_POST['appointment_id'];
    $action = $_POST['action'];

    // Update the appointment status based on action
    if ($action === 'approve') {
        $status = 'approved';
    } elseif ($action === 'reject') {
        $status = 'rejected';
    } else {
        $status = 'pending'; // Default to pending for invalid actions
    }

    $stmt_update = $conn->prepare("UPDATE appointments SET status = ? WHERE appointment_id = ?");
    $stmt_update->bind_param("si", $status, $appointment_id);
    if ($stmt_update->execute()) {
        header("Location: meetings.php");
        exit();
    } else {
        echo "Error updating appointment status.";
    }
}

// Fetch pending meetings for approval
$sql_pending = "SELECT a.appointment_id, a.appointment_date, s.firstName AS student_name 
                FROM appointments a 
                JOIN student s ON a.studentid = s.studentid 
                WHERE a.lecturerid = ? AND a.status = 'pending'";
$stmt_pending = $conn->prepare($sql_pending);
$stmt_pending->bind_param("i", $lecturer_id);
$stmt_pending->execute();
$result_pending = $stmt_pending->get_result();

// Fetch approved/rejected meetings
$sql_approved = "SELECT a.appointment_date, a.status, s.firstName AS student_name 
                 FROM appointments a 
                 JOIN student s ON a.studentid = s.studentid 
                 WHERE a.lecturerid = ? AND a.status != 'pending'";
$stmt_approved = $conn->prepare($sql_approved);
$stmt_approved->bind_param("i", $lecturer_id);
$stmt_approved->execute();
$result_approved = $stmt_approved->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Meetings</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Meetings</h1>
        <button class="logout-button" onclick="location.href='../auth/logout.php'">Logout</button>
    </header>
    <main>
        <div class="container">
            <!-- Approve Meetings Section -->
            <h2>Approve Meetings</h2>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Student Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_pending->num_rows > 0): ?>
                        <?php while ($row = $result_pending->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                                <td>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                        <button type="submit" name="action" value="approve" class="action-button approve-button">Approve</button>
                                    </form>
                                    <form method="POST" style="display:inline;">
                                        <input type="hidden" name="appointment_id" value="<?php echo $row['appointment_id']; ?>">
                                        <button type="submit" name="action" value="reject" class="action-button reject-button">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No pending meetings.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Approved Meetings Section -->
            <h2>Approved Meetings</h2>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Student Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_approved->num_rows > 0): ?>
                        <?php while ($row = $result_approved->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No approved/rejected meetings.</td>
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
