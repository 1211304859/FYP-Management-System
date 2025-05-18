<?php
session_start();
require_once '../includes/db_connect.php';
$conn = OpenCon();

// Ensure lecturer is logged in
if (!isset($_SESSION['userid']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: ../auth/lecturer_login.php");
    exit();
}

$lecturer_id = $_SESSION['userid']; // Fetch lecturer ID from session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = "Pending"; // Default status

    // Validate inputs
    if (empty($title) || empty($description)) {
        echo "<script>alert('All fields are required.'); window.location.href='submit_proposal.php';</script>";
        exit();
    }

    // Ensure lecturer ID is not null
    if (empty($lecturer_id)) {
        echo "<script>alert('Error: Lecturer ID is missing. Please log in again.'); window.location.href='../auth/lecturer_login.php';</script>";
        exit();
    }

    // Insert proposal into database
    $stmt = $conn->prepare("INSERT INTO proposals (lecturerid, title, description, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $lecturer_id, $title, $description, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Proposal submitted successfully.'); window.location.href='lecturer_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error submitting proposal. Please try again.'); window.location.href='submit_proposal.php';</script>";
    }

    $stmt->close();
}

CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Submit FYP Proposal</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>FCI FYP Management System</h1>
    </header>
    <main>
        <div class="card">
            <h2>Submit FYP Proposal</h2>
            <?php if (isset($success)) echo "<p class='success'>$success</p>"; ?>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST">
                <label for="title">Proposal Title:</label>
                <input type="text" id="title" name="title" required>
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>
                <button type="submit">Submit Proposal</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
