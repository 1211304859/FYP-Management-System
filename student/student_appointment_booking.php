<?php
session_start();
require_once '../includes/db_connect.php';

// Open database connection
$conn = OpenCon();

// Redirect if user is not logged in as a student
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/student_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lecturer_id = $_POST['lecturer_id'];
    $appointment_date = $_POST['appointment_date'];

    // Prepare and execute the insert query
    $sql = "INSERT INTO appointments (studentid, lecturerid, appointment_date, status) VALUES (?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $_SESSION['userid'], $lecturer_id, $appointment_date);

    if ($stmt->execute()) {
        $success = "Appointment requested successfully!";
    } else {
        $error = "Failed to request appointment.";
    }
}

// Fetch lecturers
$lecturers = $conn->query("SELECT lecturerid, firstName, lastName FROM lecturer");

// Close database connection
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Appointments</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>FCI FYP Management System</h1>
        <button class="logout-button" onclick="window.location.href='../auth/student_logout.php'">Logout</button>
    </header>
    <main>
        <div class="card">
            <h2>Book an Appointment</h2>
            
            <!-- Display success or error messages -->
            <?php if (isset($success)): ?>
                <p class="success"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <!-- Appointment form -->
            <form method="POST">
                <label for="lecturer_id">Select Lecturer:</label>
                <select id="lecturer_id" name="lecturer_id" required>
                    <option value="" disabled selected>Select a Lecturer</option>
                    <?php while ($row = $lecturers->fetch_assoc()): ?>
                        <option value="<?php echo $row['lecturerid']; ?>">
                            <?php echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label for="appointment_date">Appointment Date:</label>
                <input type="datetime-local" id="appointment_date" name="appointment_date" required>
                
                <button type="submit">Request Appointment</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
