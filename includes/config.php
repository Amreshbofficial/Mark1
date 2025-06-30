<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "brand_bazaar";



// Create mysqli connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Global functions
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>