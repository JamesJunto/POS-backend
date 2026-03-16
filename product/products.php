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
    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        if (deleteProduct($conn, $data)) {
            echo json_encode(["message" => "Product deleted successfully"]);
        } else {
            echo json_encode(["message" => "Failed to delete product"]);
        }
        break;
    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        if (updateProduct($conn, $data)) {
            echo json_encode(["message" => "Product updated successfully"]);
        } else {
            echo json_encode(["message" => "Failed to update product"]);
        }
        break;
    default:
        echo json_encode(["message" => "Method Not Allowed"]);
}


