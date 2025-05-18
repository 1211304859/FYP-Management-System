<?php
session_start();
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/admin_session.php';


$conn = OpenCon();

// Fetch all assigned FYPs
$assignedFYPs = $conn->query("SELECT assigned_fyp.assignmentid, student.firstName AS studentFirstName, student.lastName AS studentLastName, lecturer.firstName AS lecturerFirstName, lecturer.lastName AS lecturerLastName, proposals.title, assigned_fyp.progress FROM assigned_fyp JOIN student ON assigned_fyp.studentid = student.studentid JOIN lecturer ON assigned_fyp.lecturerid = lecturer.lecturerid JOIN proposals ON assigned_fyp.proposalid = proposals.proposalid");

CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - View Assigned FYPs</title>
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
        <div class="table-container">
            <h2>Assigned FYPs</h2>
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Lecturer</th>
                        <th>Project Title</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($assignedFYPs->num_rows > 0) { ?>
                        <?php while ($row = $assignedFYPs->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['studentFirstName'] . ' ' . $row['studentLastName']); ?></td>
                                <td><?php echo htmlspecialchars($row['lecturerFirstName'] . ' ' . $row['lecturerLastName']); ?></td>
                                <td><?php echo htmlspecialchars($row['title']); ?></td>
                                <td><?php echo htmlspecialchars($row['progress']); ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr><td colspan="4">No assigned FYPs found.</td></tr>
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
