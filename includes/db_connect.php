<?php
// Database connection file

function OpenCon() {
    $dbhost = "localhost";  // Change if necessary
    $dbuser = "root";       // Default user in XAMPP
    $dbpass = "";           // Default password in XAMPP (empty)
    $dbname = "project";    // Database name from project.sql

    // Establish connection
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

    // Check for connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

function CloseCon($conn) {
    $conn->close();
}
?>
