<?php

// require "../includes/dbh.inc.php";
require "./includes/dbh.inc.php";

$query = "CREATE TABLE IF NOT EXISTS migrations(
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $query)) {
    $error = "Statement preparation failed upon Create migrations table!";
    return json_encode($error);
}

mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
