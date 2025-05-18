<?php
session_start();
session_unset();  // Clears session variables
session_destroy(); // Destroys the session

echo "<script>alert('You have been logged out.'); window.location.href='../auth/admin_login.html';</script>";
exit();
?>
