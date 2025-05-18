<?php
session_start();
require_once __DIR__ . '/../includes/db_connect.php'; // Connects to the database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize user input
    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
    $password = htmlspecialchars(trim($_POST['password']), ENT_QUOTES, 'UTF-8');
    
    // Check if input is valid
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in both fields.'); window.location.href='admin_login.html';</script>";
        exit();
    }

    $conn = OpenCon(); // Open DB connection

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT adminid, firstName, lastName, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['admin_id'] = $row['adminid'];
            $_SESSION['admin_name'] = $row['firstName'] . " " . $row['lastName'];

            // Update last login timestamp
            $update_stmt = $conn->prepare("UPDATE admin SET last_login = NOW() WHERE adminid = ?");
            $update_stmt->bind_param("i", $row['adminid']);
            $update_stmt->execute();
            $update_stmt->close();
            
            echo "<script>window.location.href='../admin/admin_homepage.php';</script>";
            exit();
        } else {
            echo "<script>alert('Incorrect email or password.'); window.location.href='admin_login.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('No account found with this email.'); window.location.href='admin_login.html';</script>";
        exit();
    }

    $stmt->close();
    CloseCon($conn); // Close DB connection
}
?>
