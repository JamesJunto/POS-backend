<?php
session_start();

require_once("../connection.php");
require_once("../cors.php");
require_once("auth_functions.php");
function validate($conn,$data)
{
    $name = $data['name'];
    $password = $data['password'];

    $sql = "SELECT id, name, password FROM users WHERE name = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $password);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        session_regenerate_id(true);
         $_SESSION['user_id'] = $user['id'];
         $_SESSION['user_name'] = $user['name'];
        return [
            "success" => true,
            "message" => "Successfully logged in",
        ];
    } else {
        return [
            "success" => false,
            "message" => "Invalid credentials",
        ];
    }
 }
 function logout() {
    $_SESSION = [];
    session_unset();   
    session_destroy();
    return [
        "success" => true,
        "message" => "Logged out successfully"
    ];
}

