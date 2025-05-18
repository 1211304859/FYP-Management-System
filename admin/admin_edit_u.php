<?php
session_start();
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/admin_session.php';

$conn = OpenCon();

// handles edit user
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['role'])) {
    $id = intval($_POST['id']);
    $role = $_POST['role'];
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    
    // finds the correct table and column
    if ($role === 'Admin') {
        $table = 'admin';
        $column = 'adminid';
    } elseif ($role === 'Lecturer') {
        $table = 'lecturer';
        $column = 'lecturerid';
    } else {
        $table = 'student';
        $column = 'studentid';
    }
    
    $stmt = $conn->prepare("UPDATE $table SET firstName = ?, lastName = ?, email = ? WHERE $column = ?");
    $stmt->bind_param("sssi", $firstName, $lastName, $email, $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully.'); window.location.href='admin_manage_u.php';</script>";
    } else {
        echo "<script>alert('Error updating user.'); window.location.href='admin_manage_u.php';</script>";
    }
    
    $stmt->close();
}

// Fetch User Data for Editing
if (isset($_GET['id']) && isset($_GET['role'])) {
    $id = intval($_GET['id']);
    $role = $_GET['role'];
    
    if ($role === 'Admin') {
        $table = 'admin';
        $column = 'adminid';
    } elseif ($role === 'Lecturer') {
        $table = 'lecturer';
        $column = 'lecturerid';
    } else {
        $table = 'student';
        $column = 'studentid';
    }
    
    $stmt = $conn->prepare("SELECT firstName, lastName, email FROM $table WHERE $column = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($firstName, $lastName, $email);
    $stmt->fetch();
    $stmt->close();
}

CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
         /* Navigation Bar Styles */
         nav {
            background-color: #c29958;
            padding: 10px;
            text-align: center;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;   
            padding: 8px 12px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        nav ul li a:hover {
            background-color: #a67c3a;
        }
        .page {
            display: block !important;
        }
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            width: 100%;
            padding: 12px;
            background-color: #c29958;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-container button:hover {
            background-color: #a67c3a;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>FCI FYP Management System - Admin</h1>
            <button class="logout-button" onclick="window.location.href='../auth/admin_logout.php'">Logout</button>
        </div>
    </header>
    
    <nav>
        <ul>
            <li><a href="admin_homepage.php">Dashboard</a></li>
            <li><a href="admin_create_u.html">Create Users</a></li>
            <li><a href="admin_manage_u.php">Manage Users</a></li>
            <li><a href="admin_view_proposal.php">View Proposals</a></li>
            <li><a href="admin_assign_proj.php">Assign Projects</a></li>
            <li><a href="admin_view_assigned.php">View Assigned Projects</a></li>
        </ul>
    </nav>
    
    <section class="page">
        <div class="form-container">
            <h2>Edit User</h2>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="role" value="<?php echo htmlspecialchars($role); ?>">
                
                <label for="firstName">First Name</label>
                <input type="text" name="firstName" id="firstName" value="<?php echo htmlspecialchars($firstName); ?>" required>
                
                <label for="lastName">Last Name</label>
                <input type="text" name="lastName" id="lastName" value="<?php echo htmlspecialchars($lastName); ?>" required>
                
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($email); ?>" required>
                
                <button type="submit">Update User</button>
            </form>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>

