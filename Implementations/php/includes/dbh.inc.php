<?php

// Create variables to save the data needed for a connection
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "schoox";

// Create the connection using MySQLi function
$conn = mysqli_connect($host, $dbUsername, $dbPassword, $dbName);

// Check if the connection was successful
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
