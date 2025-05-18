<?php
session_start();
session_unset();  // Clear all session variables
session_destroy(); // Destroy the session

// Redirect to the student login page
header("Location: student_login.php");
exit();
?>
