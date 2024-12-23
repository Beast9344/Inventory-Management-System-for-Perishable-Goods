<?php
// Include database connection file
include('connect.php');

// Check if product_id is set and is a valid value
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    // Prepare the DELETE query to delete the selected product
    $query = "DELETE FROM products WHERE product_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        // Bind the product_id to the prepared statement
        $stmt->bind_param('s', $product_id);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Product deleted successfully.";
        } else {
            echo "Error deleting product.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }
} else {
    echo "Invalid request.";
}

// Close the connection
$conn->close();
?>
