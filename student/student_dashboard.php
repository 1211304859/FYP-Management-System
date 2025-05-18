<?php
session_start();

// Check if user is logged in as a student
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'student') {
    header("Location: ../auth/student_login.php"); // Redirect to login
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>FCI FYP Management System</h1>
        <button class="logout-button" onclick="window.location.href='../auth/logout.php'">Logout</button> 
    </header>
    <main>
        <div class="card">
            <h2>Welcome, Student</h2>
            <ul>
                <li><a href="view_fyp.php" class="card-link">View Your FYP</a></li>
                <li><a href="student_appointment_booking.php" class="card-link">Book Appointment</a></li>
                <li><a href="view_appointments.php" class="card-link">View Appointments</a></li> 
            </ul>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
<button class="logout-button" onclick="location.href='../auth/student_logout.php'">Logout</button>

