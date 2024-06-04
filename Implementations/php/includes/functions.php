<?php

function getAllCourses($conn)
{
    $query = "SELECT * FROM courses;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        // header("location: ../?error=stmtFailed");
        $error = "Statement preparation failed! GET /courses";
        return json_encode($error);
        // exit();
    }

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $response = [];

    while ($row = mysqli_fetch_assoc($result)) {
        array_push($response, $row);
        // print_r($row);
    }

    return json_encode($response);
}

function getCourseByID($conn, $id)
{
    $query = "SELECT * FROM courses WHERE id = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        // header("location: ../?error=stmtFailed");
        $error = "Statement preparation failed! GET /courses/" . $id;
        return json_encode($error);
        // exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $response = [];

    if ($row = mysqli_fetch_assoc($result)) {
        array_push($response, $row);
    } else {
        array_push($response, ["error" => "No entries found with this id: " . $id]);
    }

    return json_encode($response);
}

function createCourse($conn, $title, $description, $status, $is_premium)
{
    $query = "INSERT INTO courses(title, description, status, is_premium, created_at, deleted_at) VALUES (?,?,?,?,?,?)";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        // header("location: ../?error=stmtFailed");
        $error = "Statement preparation failed! POST /courses";
        return json_encode($error);
        // exit();
    }

    $now = date("Y/m/d h:i:sa");
    // $now = time();

    // var_dump($now);

    // return;


    mysqli_stmt_bind_param($stmt, "sssiss", $title, $description, $status, $is_premium, $now, $now);
    mysqli_stmt_execute($stmt);

    // $result = mysqli_stmt_get_result($stmt);
    // $response = [];

    // if ($row = mysqli_fetch_assoc($result)) {
    //     array_push($response, $row);
    // } else {
    //     array_push($response, ["error" => "There was an error while " . $id]);
    // }


    $response = [
        "error" => mysqli_stmt_error($stmt)
    ];

    mysqli_stmt_close($stmt);
    return json_encode($response);
}
