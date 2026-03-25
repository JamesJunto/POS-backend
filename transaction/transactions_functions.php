<?php
require_once("../connection.php");
require_once("../cors.php");

function getRecentTransactions($conn)
{
    $sql = "SELECT 
                t.transaction_id, 
                t.customer_name, 
                t.cash, 
                t.total AS transaction_total,
                t.transaction_date,
                ti.quantity, 
                ti.price AS item_price, 
                ti.total AS item_total,
                p.name AS product_name
            FROM transactions t
            JOIN transaction_items ti ON t.transaction_id = ti.transaction_id
            JOIN products p ON ti.product_id = p.id
            ORDER BY t.transaction_date DESC";

    $result = $conn->query($sql);
    $transactions = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
    }

    return $transactions;
}

   function createTransaction($conn, $transactionData, $items) {
    $sql = "INSERT INTO transactions (transaction_id, customer_name, cash, total, change_amount)
            VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssiii",
        $transactionData['transaction_id'],
        $transactionData['customer_name'],
        $transactionData['cash'],
        $transactionData['total'],
        $transactionData['change_amount']
    );
    $success = $stmt->execute();

    if (!$success) return false;

    $sqlItem = "INSERT INTO transaction_items (transaction_id, product_id, quantity, price, total)
                VALUES (?, ?, ?, ?, ?)";
    $stmtItem = $conn->prepare($sqlItem);

    foreach ($items as $item) {
        $stmtItem->bind_param(
            "siiii",
            $transactionData['transaction_id'],
            $item['product_id'],
            $item['quantity'],
            $item['price'],
            $item['quantity']
        );
        $stmtItem->execute();

        $newStock = $item['stock'];
        $updateStock = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $updateStock->bind_param("ii", $newStock, $item['product_id']);
        $updateStock->execute();
    }

    return true;
}
