<?php
// Include database connection file
include('connect.php');

// Check if order_id is set and is a valid value
if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {
    $orderId = $_POST['order_id'];

    // Prepare the DELETE query to delete the selected order
    $query = "DELETE FROM orders WHERE order_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        // Bind the order_id to the prepared statement
        $stmt->bind_param('s', $orderId);
        
        // Execute the query
        if ($stmt->execute()) {
            echo "Order deleted successfully.";
        } else {
            echo "Error deleting order.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
