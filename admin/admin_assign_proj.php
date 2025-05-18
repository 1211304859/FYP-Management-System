<?php
session_start();
require_once __DIR__ . '/../includes/db_connect.php';// Ensure only logged-in admins can access
require_once __DIR__ . '/../includes/admin_session.php';

$conn = OpenCon();

// Fetch approved proposals
$proposals = $conn->query("SELECT proposalid, title FROM proposals WHERE status = 'Approved'");

// Fetch students who haven't been assigned a project yet
$students = $conn->query("SELECT studentid, firstName, lastName FROM student WHERE studentid NOT IN (SELECT studentid FROM assigned_fyp)");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentid = intval($_POST['studentid']);
    $proposalid = intval($_POST['proposalid']);

    // Fetch the lecturerid from the proposals table
    $stmt = $conn->prepare("SELECT lecturerid FROM proposals WHERE proposalid = ?");
    $stmt->bind_param("i", $proposalid);
    $stmt->execute();
    $stmt->bind_result($lecturerid);
    $stmt->fetch();
    $stmt->close();

    if (!$lecturerid) {
        echo "<script>alert('Error: Proposal not linked to a lecturer.'); window.location.href='admin_assign_proj.php';</script>";
        exit();
    }

    // Insert assignment into assigned_fyp table
    $stmt = $conn->prepare("INSERT INTO assigned_fyp (studentid, lecturerid, proposalid, progress) VALUES (?, ?, ?, 'Not Started')");
    $stmt->bind_param("iii", $studentid, $lecturerid, $proposalid);

    if ($stmt->execute()) {
        echo "<script>alert('Project assigned successfully.'); window.location.href='admin_assign_proj.php';</script>";
    } else {
        echo "<script>alert('Error assigning project.'); window.location.href='admin_assign_proj.php';</script>";
    }

    $stmt->close();
}

CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Assign Projects</title>
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
        .form-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .form-container select, .form-container button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #c29958;
            color: white;
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
            <h2>Assign Project to Student</h2>
            <form action="" method="POST">
                <label for="proposalid">Select Approved Proposal:</label>
                <select name="proposalid" id="proposalid" required>
                    <option value="">Select Proposal</option>
                    <?php while ($row = $proposals->fetch_assoc()) { ?>
                        <option value="<?php echo $row['proposalid']; ?>"> <?php echo htmlspecialchars($row['title']); ?> </option>
                    <?php } ?>
                </select>
                
                <label for="studentid">Select Student:</label>
                <select name="studentid" id="studentid" required>
                    <option value="">Select Student</option>
                    <?php while ($row = $students->fetch_assoc()) { ?>
                        <option value="<?php echo $row['studentid']; ?>"> <?php echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']); ?> </option>
                    <?php } ?>
                </select>
                
                <button type="submit">Assign Project</button>
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

