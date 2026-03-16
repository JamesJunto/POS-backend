<?php
require_once("../connection.php");
require_once("../cors.php");

function getRecentTransactions($conn){

    $sql = "SELECT t.transaction_id, t.quantity,t.price,t.transaction_date, t.total, p.name AS product_name,p.price AS product_current_price
    FROM transactions t
    JOIN products p
    ON t.product_id = p.id
    ORDER BY t.transaction_date DESC
    LIMIT 5;";

    $result = $conn->query($sql);
    $transactions = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
    }
    return $transactions;

}