<?php

require_once("../connection.php");
require_once("../cors.php");
require_once("transactions_functions.php");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $transactions = getRecentTransactions($conn);
        echo json_encode($transactions);
        break;
    default:
        http_response_code(405);
        echo json_encode(["message" => "Method Not Allowed"]);
        break;
}