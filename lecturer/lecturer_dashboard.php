<?php
session_start();
require_once '../includes/db_connect.php';
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: ../auth/lecturer_login.php"); // Redirect to login
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Lecturer Dashboard</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>Welcome, Lecturer</h1>
        <button class="logout-button" onclick="location.href='../auth/logout.php'">Logout</button>
    </header>
    <main>
        <div class="card">
            <h2>Quick Links</h2>
            <a href="view_students.php" class="card-link">View Assigned Students</a>
            <a href="submit_proposal.php" class="card-link">Submit FYP Proposals</a>
            <a href="meetings.php" class="card-link">Meetings</a> 
        </div>
    </main>
    <footer>
        <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
<button class="logout-button" onclick="location.href='../auth/lecturer_logout.php'">Logout</button>
