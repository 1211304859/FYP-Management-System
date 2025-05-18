<?php
session_start();
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/admin_session.php';

$conn = OpenCon();

// handles user deletion
if (isset($_GET['delete']) && isset($_GET['id']) && isset($_GET['role'])) {
    $id = intval($_GET['id']);
    $role = $_GET['role'];
    
    // Determine the correct table and column
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
    
    $stmt = $conn->prepare("DELETE FROM $table WHERE $column = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.href='admin_manage_u.php';</script>";
    } else {
        echo "<script>alert('Error deleting user.'); window.location.href='admin_manage_u.php';</script>";
    }

    $stmt->close();
}
// finds all admins, lecturers, and students
$users = $conn->query("SELECT adminid AS id, firstName, lastName, email, 'Admin' AS role, last_login FROM admin 
                        UNION 
                        SELECT lecturerid AS id, firstName, lastName, email, 'Lecturer' AS role, NULL FROM lecturer
                        UNION 
                        SELECT studentid AS id, firstName, lastName, email, 'Student' AS role, NULL FROM student");

CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Manage Users</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .page {
            display: block !important;
        }
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
        .table-container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        #search {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        th, td {
            text-align: left;
            padding: 12px;
        }
        th {
            background-color: #c29958;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:nth-child(odd) {
            background-color: #fff;
        }
        tr:hover {
            background-color: #f0e6d2;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        .action-buttons button {
            margin-right: 5px;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .edit-btn:hover {
            background-color: #45a049;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .delete-btn:hover {
            background-color: #d32f2f;
        }
    </style>
    <script>
        function filterTable() {
            let input = document.getElementById("search").value.toLowerCase();
            let rows = document.querySelectorAll("tbody tr");
            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(input) ? "" : "none";
            });
        }
    </script>
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
        <div class="table-container">
            <h2>Manage Users</h2>
            <input type="text" id="search" onkeyup="filterTable()" placeholder="Search users">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users->num_rows > 0) { ?>
                        <?php while ($row = $users->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td><?php echo htmlspecialchars($row['last_login'] ?? 'N/A'); ?></td>
                                <td class="action-buttons">
                                    <button class="edit-btn" onclick="window.location.href='admin_edit_u.php?id=<?php echo $row['id']; ?>&role=<?php echo $row['role']; ?>'">Edit</button>
                                    <button class="delete-btn" onclick="if(confirm('Are you sure you want to delete this user?')) window.location.href='admin_manage_u.php?delete=1&id=<?php echo $row['id']; ?>&role=<?php echo $row['role']; ?>'">Delete</button>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr><td colspan="5">No users found.</td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
    <footer>
        <div class="container">
            <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>


