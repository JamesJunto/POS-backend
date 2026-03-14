<?php
$host = "localhost";
$db = "pos";
$user = "root";
$pass = "james123";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed"]);
    exit;
}