<?php

require_once("../connection.php");
require_once("../cors.php");
require_once("transactions_functions.php");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $transactions = getRecentTransactions($conn);
        echo json_encode($transactions);
        break;
        
    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        $result = createTransaction($conn, $data);
        if ($result) {
            echo json_encode(["message" => "Transaction created successfully"]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Failed to create transaction"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}