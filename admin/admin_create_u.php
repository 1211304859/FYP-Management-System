<?php
session_start();
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/admin_session.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST); // Debugging line - check received data
    
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $password = trim($_POST['password']);

    if (empty($firstName) || empty($lastName) || empty($email) || empty($role) || empty($password)) {
        echo "<script>alert('All fields are required.'); window.location.href='admin_create_u.html';</script>";
        exit();
    }
}
    
    $conn = OpenCon();
    
    // Check if email already exists
    $table = ($role === 'admin') ? 'admin' : 'lecturer';
    $stmt = $conn->prepare("SELECT email FROM $table WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email already exists.'); window.location.href='admin_create_u.html';</script>";
        exit();
    }
    
    $stmt->close();
    
    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Insert new user
    $stmt = $conn->prepare("INSERT INTO $table (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
    
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashed_password);
    
    if ($stmt->execute()) {
        echo "<script>alert('User created successfully.'); window.location.href='admin_homepage.php';</script>";
    } else {
        echo "<script>alert('Error creating user.'); window.location.href='admin_create_u.html';</script>";
    }
    
    $stmt->close();
    CloseCon($conn);

?>
