<?php
session_start();
if (!isset($_SESSION['role'])) {
    header("Location: ../auth/login.php");
    exit;
}

$role = $_SESSION['role'];
header("Location: {$role}_dashboard.php");
exit;
?>
