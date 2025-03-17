<?php
// Database credentials
$host = 'localhost';
$user = 'root';
$pass = '';

// Connect to MySQL server
$mysqli = new mysqli($host, $user, $pass);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Read and execute SQL file
$sql = file_get_contents('mms-database.sql');

if ($mysqli->multi_query($sql)) {
    echo "Database imported successfully";
} else {
    echo "Error importing database: " . $mysqli->error;
}

$mysqli->close();
?> 