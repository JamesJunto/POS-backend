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
    $input = json_decode(file_get_contents("php://input"), true);

    $transaction = $input['transaction']; 
    $items = $input['items'];           

    $result = createTransaction($conn, $transaction, $items);

    if ($result) {
        echo json_encode(["message" => "Transaction created successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Failed to create transaction"]);
    }
    break;
}