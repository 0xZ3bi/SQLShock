<?php
// Database connection settings
$db_host = 'localhost';
$db_user = 'root'; // Default XAMPP/WAMP username
$db_pass = ''; // Default XAMPP/WAMP password (empty)
$db_name = 'database';

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Display errors (not recommended for production, but useful for educational purposes)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Session start
session_start();
?> 