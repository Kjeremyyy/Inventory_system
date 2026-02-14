<?php

$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "Inventory"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: set charset
$conn->set_charset("utf8mb4");

?>
