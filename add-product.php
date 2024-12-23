<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $category = $_POST['category'];
    $stockQuantity = $_POST['stock_quantity'];
    $price = $_POST['price'];

    // Insert the product into the database
    $sql = "INSERT INTO products (product_id, product_name, category, stock_quantity, price) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $productId, $productName, $category, $stockQuantity, $price);

    if ($stmt->execute()) {

        echo "Product added successfully.";

        // Redirect to products.php after successful insertion
        header("Location: products.php");
        exit(); // Don't forget to call exit() to stop further script execution
    } else {
        echo "Error adding product: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>