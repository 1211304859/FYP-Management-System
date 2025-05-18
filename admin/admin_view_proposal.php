<?php
session_start();
require_once __DIR__ . '/../includes/db_connect.php';
require_once __DIR__ . '/../includes/admin_session.php';

$conn = OpenCon();

// Handle approval and rejection actions
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proposalid'])) {
    $proposalid = intval($_POST['proposalid']);
    $action = $_POST['action'];
    
    if ($action === 'approve') {
        $status = 'Approved';
    } elseif ($action === 'reject') {
        $status = 'Rejected';
    } else {
        echo "<script>alert('Invalid action.'); window.location.href='admin_view_proposal.php';</script>";
        exit();
    }
    
    $stmt = $conn->prepare("UPDATE proposals SET status = ? WHERE proposalid = ?");
    $stmt->bind_param("si", $status, $proposalid);
    
    if ($stmt->execute()) {
        echo "<script>alert('Proposal updated successfully.'); window.location.href='admin_view_proposal.php';</script>";
    } else {
        echo "<script>alert('Error updating proposal.'); window.location.href='admin_view_proposal.php';</script>";
    }
    
    $stmt->close();
}

// Fetch all proposals with sorting (Pending first, then Approved/Rejected)
$result = $conn->query("
    SELECT proposals.proposalid, proposals.title, proposals.description, proposals.status, 
           lecturer.firstName, lecturer.lastName 
    FROM proposals 
    LEFT JOIN lecturer ON proposals.lecturerid = lecturer.lecturerid 
    ORDER BY FIELD(status, 'Pending', 'Approved', 'Rejected')
");

if (!$result) {
    die("SQL Error: " . $conn->error);
}
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - View Proposals</title>
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
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .approve-button {
            background-color: #4CAF50; /* Green */
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .approve-button:hover {
            background-color: #45a049;
        }
        .reject-button {
            background-color: #f44336; /* Red */
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .reject-button:hover {
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
            <h2>Submitted Proposals</h2>
            <input type="text" id="search" onkeyup="filterTable()" placeholder="Search proposals, supervisors...">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Supervisor</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['description']); ?></td>
                            <td><?php echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                            <td>
                                <?php if ($row['status'] === 'pending') { ?>
                                    <form method="post" action="" class="action-buttons">
                                        <input type="hidden" name="proposalid" value="<?php echo $row['proposalid']; ?>">
                                        <button type="submit" name="action" value="approve" class="approve-button">Approve</button>
                                        <button type="submit" name="action" value="reject" class="reject-button">Reject</button>
                                    </form>
                                <?php } else { ?>
                                    <span><?php echo $row['status']; ?></span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>












