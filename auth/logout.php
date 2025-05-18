<?php
session_start();
session_unset();  // Clears session variables
session_destroy(); // Destroys the session

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            $redirect = 'admin_login.html';
            break;
        case 'lecturer':
            $redirect = 'lecturer_login.php';
            break;
        case 'student':
            $redirect = 'student_login.php';
            break;
        default:
            $redirect = 'index.php';
    }
} else {
    $redirect = 'index.php';
}

echo "<script>alert('You have been logged out.'); window.location.href='$redirect';</script>";
exit();
?>
