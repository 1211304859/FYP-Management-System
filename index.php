<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FCI FYP Management System</title>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .login-container {
            text-align: center;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            color: #c29958;
        }
        .login-container button {
            display: block;
            width: 100%;
            background-color: #c29958;
            color: white;
            border: none;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .login-container button:hover {
            background-color: #a67c3a;
        }
        .register-link {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #c29958;
            font-weight: bold;
        }
        .register-link:hover {
            color: #a67c3a;
        }
    </style>
</head>
<body>
    <header>
        <h1>FCI FYP Management System</h1>
    </header>
    <main>
        <div class="login-container">
            <h2>Login</h2>
            <p>Choose your role to log in:</p>
            <button onclick="location.href='auth/student_login.php?role=student'">Login as Student</button>
            <button onclick="location.href='auth/lecturer_login.php?role=lecturer'">Login as Lecturer</button>
            <button onclick="location.href='auth/admin_login.html'">Login as Admin</button>
            <a class="register-link" href="student/register.php">Not registered? Register here</a>
        </div>
    </main>
    <footer>
        <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
    </footer>
</body>
</html>
