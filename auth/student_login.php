<?php
session_start();
require_once '../includes/db_connect.php';

$conn = OpenCon();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT studentid, firstName, lastName, password FROM student WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                // ✅ Store session variables correctly
                $_SESSION['userid'] = $user['studentid'];
                $_SESSION['role'] = 'student';
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];

                // ✅ Redirect to student dashboard
                header("Location: ../student/student_dashboard.php");
                exit();
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "User not found.";
        }
        $stmt->close();
    }
}

CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Login</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header><h1>Student Login</h1></header>
    <main>
        <div class="card">
            <h2>Login</h2>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <form method="POST">
                <label for="email">Email:</label>
                <input type="email" name="email" placeholder="Enter your email" required>
                <label for="password">Password:</label>
                <input type="password" name="password" placeholder="Enter your password" required>
                <button type="submit">Login</button>
            </form>
        </div>
    </main>
</body>
</html>
