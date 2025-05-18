<?php
session_start();
session_unset();  // Clear all session variables
session_destroy(); // Destroy the session

// Redirect to the lecturer login page
header("Location: lecturer_login.php");
exit();
?>
