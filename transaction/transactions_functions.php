<?php
require_once("../connection.php");
require_once("../cors.php");

function getRecentTransactions($conn)
{

 $sql = "SELECT 
  t.transaction_id, 
  p.name AS product_name,
  t.price, 
  t.quantity, 
  (t.quantity * t.price) AS total, 
  p.price AS product_current_price,
  t.transaction_date
    FROM transactions t
    JOIN products p
    ON t.product_id = p.id
    ORDER BY t.transaction_date DESC
    ";

    $result = $conn->query($sql);
    $transactions = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
    }
    return $transactions;

}

function createTransaction($conn, $data)
{
    $transaction_id = $data['transaction_id'];
    $product_id = $data['product_id'];
    $quantity = $data['quantity'];
    $price = $data['price'];
    $stock = $data['stock'];
    $total = $quantity * $price;

    $sql = "INSERT INTO transactions (transaction_id, product_id, quantity, price, total) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiii", $transaction_id, $product_id, $quantity, $price, $total);
    $success = $stmt->execute();

    if ($success) {
        $updatedProduct = $conn->prepare("UPDATE products SET stock =  ? WHERE id = ?");
        $updatedProduct->bind_param("ii", $stock, $product_id);
        $updatedProduct->execute();

        return true;
    } else {
        return false;
    }
}