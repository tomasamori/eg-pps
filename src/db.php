<?php

$servername = "db";
$username = "test";
$password = "test";
$database = "eg-pps";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";
?>

