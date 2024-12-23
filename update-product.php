<?php
// Include database connection
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $category = $_POST['category'];
    $stock = $_POST['stock_quantity'];
    $price = $_POST['price'];

    // SQL query to update the product
    $sql = "UPDATE products SET 
            product_name = ?, 
            category = ?, 
            stock_quantity = ?, 
            price = ? 
            WHERE product_id = ?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdis", $productName, $category, $stock, $price, $productId);

    if ($stmt->execute()) {
        echo "Product updated successfully.";
    } else {
        echo "Error updating product: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
