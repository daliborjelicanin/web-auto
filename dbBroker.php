<?php
$host = "localhost";
$db = "itehsem";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $db);
$conn->set_charset("utf8mb4");

if ($conn->connect_errno) {
    exit("Database connection failed: " . $conn->connect_errno);
}


