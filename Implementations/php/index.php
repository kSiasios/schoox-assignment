<?php
require "includes/dbh.inc.php";

// Allow for json body only!
header('Content-Type: application/json; charset=UTF-8');

$method = $_SERVER['REQUEST_METHOD'];
$pathParts = explode("/", $_SERVER['REQUEST_URI']);

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

// HANDLE GET REQUESTS
if ($method === "GET") {
    if (!$id) {
        require_once "includes/functions.php";
        $res = getAllCourses($conn);
        echo ($res);
    } else {
        require_once "includes/functions.php";
        $res = getCourseByID($conn, $id);
        echo ($res);
    }
}

// HANDLE POST REQUESTS
if ($method === "POST") {
    // WE ARE ALLOWING POST REQUESTS FOR /courses ONLY!
    // IF AN ID IS PROVIDED, WE RESPOND WITH AN ERROR
    if ($id) {
        http_response_code(405);
        exit();
    } else {
        require_once "includes/functions.php";

        // READ DATA PROVIDED BY THE REQUEST 
        $data = json_decode(file_get_contents("php://input"));

        // CHECK IF ALL NEEDED DATA WERE SET
        if (!isset($data->title) || !isset($data->description) || !isset($data->status) || !isset($data->is_premium)) {
            http_response_code(400);
            $error = "Missing Data!";
            echo ($error);
            exit();
        }

        $title = $data->title;
        $description = $data->description;
        $status = $data->status;
        $is_premium = $data->is_premium;

        // VALIDATE THE DATA
        if ($title == "" || $description == "") {
            http_response_code(400);
            $error = "Both Title AND Description are required!";
            echo ($error);
            exit();
        }

        if ($status != "Pending" && $status != "Published") {
            http_response_code(400);
            $error = "Status should have a value of 'Pending' or 'Published'!";
            echo ($error);
            exit();
        }

        if ($is_premium != true && $is_premium != false) {
            http_response_code(400);
            $error = "Is_premium should have a boolean value!";
            echo ($error);
            exit();
        }

        // CALL THE FUNCTION TO CREATE THE NEW COURSE
        $res = createCourse($conn, $title, $description, $status, $is_premium);

        // PRINT THE RESPONSE
        echo ($res);
    }
}

if ($method === "PUT") {
    // WE ARE ALLOWING POST REQUESTS FOR /courses ONLY!
    // IF AN ID IS PROVIDED, WE RESPOND WITH AN ERROR
    if (!$id) {
        http_response_code(405);
        exit();
    } else {
        require_once "includes/functions.php";

        // READ DATA PROVIDED BY THE REQUEST 
        $data = json_decode(file_get_contents("php://input"));

        // CHECK IF ALL NEEDED DATA WERE SET
        if (!isset($data->title) || !isset($data->description) || !isset($data->status) || !isset($data->is_premium)) {
            http_response_code(400);
            $error = "Missing Data!";
            echo ($error);
            exit();
        }

        $title = $data->title;
        $description = $data->description;
        $status = $data->status;
        $is_premium = $data->is_premium;


        // CHECK AT LEAST ONE DATA ENTRY HAS A VALUE


        // CHECK IF THE ENTRY EXISTS IN THE DB



        // IF THE PROVIDED DATA IS DIFFERENT THAN THE DATA OF THE ENTRY AND NOT NULL
        // KEEP THE NEW DATA, OTHERWISE -> SET THE NEW DATA = THE OLD DATA



        // UPDATE THE ENTRY
        // VALIDATE THE DATA
        if ($title == "" || $description == "") {
            http_response_code(400);
            $error = "Both Title AND Description are required!";
            echo ($error);
            exit();
        }

        if ($status != "Pending" && $status != "Published") {
            http_response_code(400);
            $error = "Status should have a value of 'Pending' or 'Published'!";
            echo ($error);
            exit();
        }

        if ($is_premium != true && $is_premium != false) {
            http_response_code(400);
            $error = "Is_premium should have a boolean value!";
            echo ($error);
            exit();
        }

        // CALL THE FUNCTION TO CREATE THE NEW COURSE
        $res = createCourse($conn, $title, $description, $status, $is_premium);

        // PRINT THE RESPONSE
        echo ($res);
    }
}

if ($method === "DELETE") {
    // WE ARE ALLOWING POST REQUESTS FOR /courses ONLY!
    // IF AN ID IS PROVIDED, WE RESPOND WITH AN ERROR
    if (!$id) {
        http_response_code(405);
        exit();
    } else {
        require_once "includes/functions.php";

        // READ DATA PROVIDED BY THE REQUEST 
        $data = json_decode(file_get_contents("php://input"));

        // CHECK IF ALL NEEDED DATA WERE SET
        if (!isset($data->title) || !isset($data->description) || !isset($data->status) || !isset($data->is_premium)) {
            http_response_code(400);
            $error = "Missing Data!";
            echo ($error);
            exit();
        }

        $title = $data->title;
        $description = $data->description;
        $status = $data->status;
        $is_premium = $data->is_premium;

        // VALIDATE THE DATA
        if ($title == "" || $description == "") {
            http_response_code(400);
            $error = "Both Title AND Description are required!";
            echo ($error);
            exit();
        }

        if ($status != "Pending" && $status != "Published") {
            http_response_code(400);
            $error = "Status should have a value of 'Pending' or 'Published'!";
            echo ($error);
            exit();
        }

        if ($is_premium != true && $is_premium != false) {
            http_response_code(400);
            $error = "Is_premium should have a boolean value!";
            echo ($error);
            exit();
        }

        // CALL THE FUNCTION TO CREATE THE NEW COURSE
        $res = createCourse($conn, $title, $description, $status, $is_premium);

        // PRINT THE RESPONSE
        echo ($res);
    }
}
