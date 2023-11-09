<?php

include "credentials.php";

// Database connection
$connection = new mysqli('localhost', $user, $pw, $db);

// Check if the connection was successful
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Select all records from scp table
$AllRecords = $connection->prepare("SELECT * FROM scp");
$AllRecords->execute();
$result = $AllRecords->get_result();

?>
