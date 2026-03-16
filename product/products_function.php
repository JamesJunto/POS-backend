
<?php
  require_once("../connection.php");
  require_once("../cors.php");

    function getProducts($conn) {
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        $products = [];
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        return $products;
    }

    function addProduct($conn, $data) {
        $name = $data['name'];
        $category = $data['category'];
        $price = $data['price'];
        $stock = $data['stock'];

        $sql = "INSERT INTO products (name, category, price, stock) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        $stmt->bind_param("ssss", $name, $category, $price, $stock);
        if ($stmt->execute() === TRUE) {
            return true;
        } else {
            return false;
        }

    }

    function deleteProduct($conn, $data){
        $id = $data['id'];
        $sql = "DELETE FROM products WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        if ($stmt->execute() === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    function updateProduct($conn, $data){
        $id = $data['id'];
        $name = $data['name'];
        $category = $data['category'];
        $price = $data['price'];
        $stock = $data['stock'];

        $sql = "UPDATE products SET name=?, category=?, price=?, stock=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $category, $price, $stock, $id);
        if ($stmt->execute() === TRUE) {
            return true;
        } else {
            return false;
        }
     }
            
    