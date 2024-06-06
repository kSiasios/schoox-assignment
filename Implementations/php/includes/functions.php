<?php

function getAllCourses($conn)
{
    $query = "SELECT * FROM courses;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! GET /courses";
        return json_encode($error);
    }

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
    $query = "SELECT * FROM courses WHERE id = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! GET /courses/" . $id;
        return json_encode($error);
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

    mysqli_stmt_close($stmt);
    return json_encode($response);
}

function createCourse($conn, $title, $description, $status, $isPremium)
{
    $query = "INSERT INTO courses(title, description, status, is_premium, created_at, deleted_at) VALUES (?,?,?,?,?,?)";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! POST /courses";
        return json_encode($error);
    }

    $now = date("Y/m/d h:i:sa");

    if ($status === "Deleted") {
        $deletedAt = $now;
    } else {
        $deletedAt = "";
    }

    mysqli_stmt_bind_param($stmt, "sssiss", $title, $description, $status, $isPremium, $now, $deletedAt);

    mysqli_stmt_execute($stmt);

    $response = [
        "error" => mysqli_stmt_error($stmt) ? mysqli_stmt_error($stmt) : "No error"
    ];

    mysqli_stmt_close($stmt);
    return json_encode($response);
}

function updateCourse($conn, $id, $title, $description, $status, $isPremium, $deletedAt)
{
    $query = "UPDATE courses
              SET title = ?, description = ?, status = ?, is_premium = ?, deleted_at = ?
              WHERE id = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! PUT /courses/" . $id;
        return json_encode($error);
    }

    mysqli_stmt_bind_param($stmt, "sssisi", $title, $description, $status, $isPremium, $deletedAt, $id);

    mysqli_stmt_execute($stmt);

    $response = [
        "error" => mysqli_stmt_error($stmt) ? mysqli_stmt_error($stmt) : "No error"
    ];

    mysqli_stmt_close($stmt);
    return json_encode($response);
}

function deleteCourse($conn, $id)
{
    $query = "DELETE FROM courses WHERE id = ?;";

    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $query)) {
        $error = "Statement preparation failed! PUT /courses/" . $id;
        return json_encode($error);
    }

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $response = [
        "error" => mysqli_stmt_error($stmt) ? mysqli_stmt_error($stmt) : "No error"
    ];

    mysqli_stmt_close($stmt);
    return json_encode($response);
}

function validation($attributes)
{
    $result = ["response" => true, "msg" => ""];

    foreach ($attributes as $type => $value) {
        if ((empty($value) || !isset($value)) && $type !== "isPremium") {
            // var_dump($attributes);
            $result["msg"] .= $type . " is required!\n";
        }

        if ($type === "status" && ($value !== "Pending" && $value !== "Published" && $value !== "Deleted")) {
            $result["msg"] .=  "Status should have a value of 'Pending', 'Published' or 'Deleted'!\n";
        }
        if ($type === "isPremium" && !is_bool($value)) {
            $result["msg"] .=  "Is_premium should have a boolean value!\n";
        }
    }

    if ($result["msg"]) {
        $result["response"] = false;
    }

    return $result;
}