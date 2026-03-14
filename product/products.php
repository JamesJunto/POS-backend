<?php
require_once("../connection.php");
require_once("../cors.php");
require_once 'products_function.php';


switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $products = getProducts($conn);
        echo json_encode($products);
        break;
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        if (addProduct($conn, $data)) {
            echo json_encode(["message" => "Product added successfully"]);
        } else {
            echo json_encode(["message" => "Failed to add product"]);
        }
        break;
    default:
        echo json_encode(["message" => "Method Not Allowed"]);
}


