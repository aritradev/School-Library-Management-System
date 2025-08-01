<?php
// Database connection for Library Management System
// Update credentials as needed for your environment

$servername = 'localhost';
$username = 'root';
$password = '';
$db_name = 'library';

// Enable MySQLi error reporting for development (remove or set to OFF in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$con = mysqli_connect($servername, $username, $password, $db_name);
if (!$con) {
    exit('Connection to the database failed: ' . mysqli_connect_error());
}
// Set charset for modern compatibility
mysqli_set_charset($con, 'utf8mb4');
