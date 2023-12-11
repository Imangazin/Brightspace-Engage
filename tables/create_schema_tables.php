<?php
require_once("../src/info.php");

// Create connection
$conn = new mysqli($db['server_name'], $db['user_name'], $db['password'], $db['db_name']);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Read SQL file
$sqlFile = 'schema.sql';
$sql = file_get_contents($sqlFile);

// Execute multi-query
if ($conn->multi_query($sql)) {
    echo "Tables created successfully";
} else {
    echo "Error creating tables: " . $conn->error;
}

$conn->close();
?>
