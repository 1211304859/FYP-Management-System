<?php
require_once __DIR__ . '/../includes/admin_session.php'; // Ensures only logged-in admins access the page
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Homepage</title>
    <link rel="stylesheet" href="../css/styles.css">
    <style>
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
            margin-top: 20px;
        }

        .button-group a {
            background-color: #a67c3a;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
            text-align: center;
            width: 80%; 
        }

        .button-group a:hover {
            background-color: #a67c3a;
            transform: scale(1.03);
        }
    
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


    <section class="page" style="display: block;">
        <div class="card">
            <h2>Welcome, Admin</h2>
            <p>Manage users, proposals, and projects using the options below:</p>
            <div class="button-group">
                <a href="admin_create_u.html">Create Admins/Lecturers</a>
                <a href="admin_view_proposal.php">View FYP Proposals</a>
                <a href="admin_assign_proj.html">Assign Students to Projects</a>
            </div>
        </div>
    </section>


    <footer>
        <div class="container">
            <p>&copy; 2025 FCI FYP Management System. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
