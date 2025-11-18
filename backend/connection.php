<?php
// connection.php
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'travel_db';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_errno) {
    die("DB Connection failed: " . $conn->connect_error);
}

// set charset
$conn->set_charset('utf8mb4');
