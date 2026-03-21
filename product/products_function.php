
<?php
  require_once("../connection.php");
  require_once("../cors.php");

    function getProducts($conn) {
        $sql = "SELECT * FROM products WHERE status = 1";
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
        if (!isset($data['id'])) {
            return [
                "success" => false,
                "message" => "Product id is required",
                "code" => 400,
            ];
        }

        $id = (int) $data['id'];
        if ($id <= 0) {
            return [
                "success" => false,
                "message" => "Invalid product id",
                "code" => 400,
            ];
        }

        $sql = "UPDATE products SET status = 0 WHERE id = ? AND status = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute() !== TRUE) {
            return [
                "success" => false,
                "message" => "Failed to archive product",
                "code" => 500,
            ];
        }

        if ($stmt->affected_rows === 0) {
            return [
                "success" => false,
                "message" => "Product not found or already archived",
                "code" => 404,
            ];
        }

        return [
            "success" => true,
            "message" => "Product archived successfully",
            "code" => 200,
        ];
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
            
    