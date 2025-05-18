<?php
require_once '../includes/db_connect.php';

$conn = OpenCon(); //  This explicitly establishes the connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO student (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

    if ($stmt->execute()) {
        CloseCon($conn); // Close connection after execution
        header("Location: ../auth/student_login.php");
        exit;
    } else {
        $error = "Registration failed: " . $conn->error;
    }

    $stmt->close();
    CloseCon($conn); // Ensure connection is closed
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header>
        <h1>FCI FYP Management System</h1>
    </header>
    <main>
        <div class="card">
            <h2>Register</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST">
                <label for="firstName">First Name:</label>
                <input type="text" id="firstName" name="firstName" placeholder="Enter your first name" required>
                
                <label for="lastName">Last Name:</label>
                <input type="text" id="lastName" name="lastName" placeholder="Enter your last name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
                
                <button type="submit">Register</button>
            </form>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
