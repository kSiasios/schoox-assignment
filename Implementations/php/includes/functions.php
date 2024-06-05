<?php

function getAllCourses($conn)
{
    // FUNCTION THAT RETURNS ALL THE COURSES IN THE DATABASE
    // PREPARE THE QUERY
    $query = "SELECT * FROM courses;";

    // PREPARE THE STATEMENT & HANDLE ERROR UPON CONNECTION
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! GET /courses";
        return json_encode($error);
    }

    // EXECUTE THE STATEMENT & RETURN THE DATA IN JSON FORMAT
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $response = [];
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($response, $row);
    }

    if ($response == []) {
        array_push($response, ["error" => "No entries found!"]);
    }

    mysqli_stmt_close($stmt);
    return json_encode($response);
}

function getCourseByID($conn, $id)
{
    // FUNCTION THAT RETURNS A COURSE THAT MATCHES THE PROVIDED ID
    // PREPARE THE QUERY
    $query = "SELECT * FROM courses WHERE id = ?;";

    // PREPARE THE STATEMENT & HANDLE ERROR UPON CONNECTION
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! GET /courses/" . $id;
        return json_encode($error);
    }

    // BIND THE PARAMETER VALUES TO THE QUERY -> ADDED SECURITY
    mysqli_stmt_bind_param($stmt, "s", $id);

    // EXECUTE THE STATEMENT & RETURN THE DATA IN JSON FORMAT
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $response = [];
    if ($row = mysqli_fetch_assoc($result)) {
        array_push($response, $row);
    } else {
        array_push($response, ["error" => "No entries found with this id: " . $id]);
    }

    mysqli_stmt_close($stmt);
    return json_encode($response);
}

function createCourse($conn, $title, $description, $status, $is_premium)
{
    // FUNCTION THAT CREATES A COURSE USING THE PROVIDED DATA
    // PREPARE THE QUERY
    $query = "INSERT INTO courses(title, description, status, is_premium, created_at, deleted_at) VALUES (?,?,?,?,?,?)";

    // PREPARE THE STATEMENT & HANDLE ERROR UPON CONNECTION
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! POST /courses";
        return json_encode($error);
    }

    // CREATE TIMESTAMP TO BE USED FOR THE created_at PARAMETER OF THE NEWLY CREATED COURSE
    $now = date("Y/m/d h:i:sa");

    // BIND THE PARAMETER VALUES TO THE QUERY -> ADDED SECURITY
    mysqli_stmt_bind_param($stmt, "sssiss", $title, $description, $status, $is_premium, $now, $now);

    // EXECUTE THE STATEMENT & RETURN THE DATA IN JSON FORMAT
    mysqli_stmt_execute($stmt);

    $response = [
        "error" => mysqli_stmt_error($stmt) ? mysqli_stmt_error($stmt) : "No error"
    ];

    mysqli_stmt_close($stmt);
    return json_encode($response);
}

function updateCourse($conn, $id, $title, $description, $status, $is_premium)
{
    // FUNCTION THAT UPDATES A COURSE THAT MATCHES THE GIVEN ID USING THE PROVIDED DATA
    // PREPARE THE QUERY
    $query = "UPDATE courses
              SET title = ?, description = ?, status = ?, is_premium = ?
              WHERE id = ?;";

    // PREPARE THE STATEMENT & HANDLE ERROR UPON CONNECTION
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! PUT /courses/" . $id;
        return json_encode($error);
    }

    // BIND THE PARAMETER VALUES TO THE QUERY -> ADDED SECURITY
    mysqli_stmt_bind_param($stmt, "sssii", $title, $description, $status, $is_premium, $id);

    // EXECUTE THE STATEMENT & RETURN THE DATA IN JSON FORMAT
    mysqli_stmt_execute($stmt);

    $response = [
        "error" => mysqli_stmt_error($stmt) ? mysqli_stmt_error($stmt) : "No error"
    ];

    mysqli_stmt_close($stmt);
    return json_encode($response);
}

function deleteCourse($conn, $id)
{
    // FUNCTION THAT UPDATES A COURSE THAT MATCHES THE GIVEN ID USING THE PROVIDED DATA
    // PREPARE THE QUERY
    $query = "DELETE FROM courses WHERE id = ?;";

    // PREPARE THE STATEMENT & HANDLE ERROR UPON CONNECTION
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! PUT /courses/" . $id;
        return json_encode($error);
    }

    // BIND THE PARAMETER VALUES TO THE QUERY -> ADDED SECURITY
    mysqli_stmt_bind_param($stmt, "i", $id);

    // EXECUTE THE STATEMENT & RETURN THE DATA IN JSON FORMAT
    mysqli_stmt_execute($stmt);

    $response = [
        "error" => mysqli_stmt_error($stmt) ? mysqli_stmt_error($stmt) : "No error"
    ];

    mysqli_stmt_close($stmt);
    return json_encode($response);
}
