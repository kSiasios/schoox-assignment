<?php

require "./includes/dbh.inc.php";

$migrationFiles = glob("migrations/*.sql");

$query = "SELECT migration FROM migrations;";

$stmt = mysqli_stmt_init($conn);

if (!mysqli_stmt_prepare($stmt, $query)) {
    $error = "Statement preparation failed upon Create migrations table!";
    return json_encode($error);
}

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$appliedMigrations = [];
while ($row = mysqli_fetch_assoc($result)) {
    array_push($appliedMigrations, $row["migration"]);
}

// Apply new migrations
foreach ($migrationFiles as $file) {
    $fileName = basename($file, '.sql');

    if (!in_array($fileName, $appliedMigrations)) {
        $query = file_get_contents($file);

        if (mysqli_multi_query($conn, $query)) {
            do {
                /* store first result set */
                if ($result = mysqli_store_result($conn)) {
                    $result->free();
                }
                /* print divider */
                if (mysqli_more_results($conn)) {
                    printf("-----------------\n");
                }
            } while (mysqli_next_result($conn));
        }

        if (mysqli_errno($conn)) {
            die("Error executing migration $fileName: " . $mysqli->error);
        }

        // Record the migration as applied
        $insertQuery = "INSERT INTO migrations (migration) VALUES (?)";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $insertQuery)) {
            $error = "Statement preparation failed upon Create migrations table!";
            return json_encode($error);
        }

        mysqli_stmt_bind_param($stmt, "s", $fileName);

        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}
