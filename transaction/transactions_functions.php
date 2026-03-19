<?php
require_once("../connection.php");
require_once("../cors.php");

function getRecentTransactions($conn){

    $sql = "SELECT t.transaction_id, t.quantity, t.price, t.transaction_date, (t.quantity * t.price) AS total, p.name AS product_name, p.price AS product_current_price
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

function createTransaction($conn, $data){
    $transaction_id = $data['transaction_id'];
    $product_id = $data['product_id'];
    $quantity = $data['quantity'];
    $price = $data['price'];
<<<<<<< HEAD
    $stock = $data['stock'];
    $total = $quantity * $price;


    $sql = "INSERT INTO transactions (transaction_id, product_id, quantity, price, total) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiii", $transaction_id, $product_id, $quantity, $price,  $total);
    $success = $stmt->execute();

    if ($success) {
        $updatedProduct = $conn->prepare("UPDATE products SET stock =  ? WHERE id = ?");
        $updatedProduct->bind_param("ii", $stock, $product_id);
        $updatedProduct->execute();
=======

    $sql = "INSERT INTO transactions (transaction_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siid", $transaction_id, $product_id, $quantity, $price);
    if ($stmt->execute() === TRUE) {
>>>>>>> 1c1de73ec804907de91ab64a61fc888ab1796ec0
        return true;
    } else {
        return false;
    }
}