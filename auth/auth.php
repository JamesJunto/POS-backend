<?php
require_once("../connection.php");
require_once("../cors.php");
require_once("./auth_functions.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if(isset($data['action']) && $data['action'] == 'login'){
         $res = validate($conn, $data);

    if ($res['success']) {
        echo json_encode([
            "success" => true,
            "message" => $res['message']
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => $res['message']
        ]);
    }
}else if(isset($data['action']) && $data['action'] == 'logout'){
    $res = logout();
    if ($res['success']) {
        echo json_encode([
            "success" => true,
            "message" => $res['message']
        ]);
    } else {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "message" => $res['message']
        ]);
    }
}

   
}