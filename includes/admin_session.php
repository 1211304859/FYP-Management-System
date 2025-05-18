<?php
// Session will only start if there isn't already an active one
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// checks if admin is not logged in
if (!isset($_SESSION['admin_id'])) {
    echo "<script>alert('Access Denied: Please log in.'); window.location.href='../auth/admin_login.html';</script>";
    exit();
}
?>

