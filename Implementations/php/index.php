<?php
require "includes/dbh.inc.php";
require_once "includes/functions.php";

// Allow for json body only!
header("Content-Type: application/json; charset=UTF-8");

$method = $_SERVER["REQUEST_METHOD"];
$pathParts = explode("/", $_SERVER["REQUEST_URI"]);

// I am building the application in a dedicated folder
// called "schoox" so the second element of the array
// will always be "schoox", unless it is moved deeper into the hierarchy
if ($pathParts[2] != "courses") {
    http_response_code(404);
    exit;
}

// EXTRACT THE ID FROM THE REQUEST IF PROVIDED
$id = null;

if (count($pathParts) > 3) {
    $id = $pathParts[3] ? $pathParts[3] : null;
}

$validateId = validation(["id" => $id]);

// HANDLE GET REQUESTS
if ($method === "GET") {
    if (!$id) {
        $res = getAllCourses($conn);
        echo $res;
    } else {
        $res = getCourseByID($conn, $id);
        echo $res;
    }
}

// HANDLE POST REQUESTS
if ($method === "POST") {
    // WE ARE ALLOWING POST REQUESTS FOR /courses ONLY!
    // IF AN ID IS PROVIDED, WE RESPOND WITH AN ERROR
    if ($validateId["response"]) {
        echo "Cannot POST with ID!";
        exit();
    } else {

        // READ DATA PROVIDED BY THE REQUEST 
        $data = json_decode(file_get_contents("php://input"));

        $title = $data->title;
        $description = $data->description;
        $status = $data->status;
        $isPremium = $data->is_premium;

        $params = [
            "title" => $title,
            "description" => $description,
            "status" => $status,
            "isPremium" => $isPremium
        ];

        $validationResults = validation($params);

        $validationResponse = $validationResults["response"];
        $validationMsg = $validationResults["msg"];

        if (!$validationResponse) {
            http_response_code(400);
            echo $validationMsg;
            exit();
        }

        $res = createCourse($conn, $title, $description, $status, $isPremium);

        echo $res;
    }
}

// HANDLE PUT REQUESTS
if ($method === "PUT") {
    // WE ARE ALLOWING PUT REQUESTS FOR /courses/{id}
    // IF AN ID IS PROVIDED, WE RESPOND WITH AN ERROR
    if (!$validateId["response"]) {
        echo $validateId["msg"];
        exit();
    } else {
        $data = json_decode(file_get_contents("php://input"));

        $title = $data->title;
        $description = $data->description;
        $status = $data->status;
        $isPremium = $data->is_premium;

        $params = [
            "title" => $title,
            "description" => $description,
            "status" => $status,
            "isPremium" => $isPremium
        ];

        $validationResults = validation($params);
        $validationMsg = $validationResults["msg"];
        $validationResponse = $validationResults["response"];

        if (!$validationResponse) {
            http_response_code(400);
            echo $validationMsg;
            exit();
        }

        $entry = json_decode(getCourseByID($conn, $id))[0];

        if (isset($entry->error)) {
            http_response_code(400);
            echo $entry->error;
            exit();
        }

        if ($status === "Deleted" && $entry->status !== "Deleted") {
            $deletedAt = date("Y/m/d h:i:sa");
        } else {
            $deletedAt = $entry->deleted_at;
        }

        $res = updateCourse($conn, $id, $title, $description, $status, $isPremium, $deletedAt);

        // PRINT THE RESPONSE
        echo $res;
    }
}

// HANDLE DELETE REQUESTS
if ($method === "DELETE") {
    // WE ARE ALLOWING POST REQUESTS FOR /courses ONLY!
    // IF AN ID IS PROVIDED, WE RESPOND WITH AN ERROR
    if (!$validateId["response"]) {
        echo $validateId["msg"];
        exit();
    } else {

        $res = deleteCourse($conn, $id);
        echo $res;
    }
}
