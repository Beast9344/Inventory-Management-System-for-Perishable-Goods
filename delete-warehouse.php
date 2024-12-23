<?php
// Include database connection file
include('connect.php');

// Check if warehouse_id is set and is a valid value
if (isset($_POST['warehouse_id'])) {
    $warehouseId = $_POST['warehouse_id'];

    // Prepare the DELETE query to delete the selected warehouse
    $query = "DELETE FROM warehouses WHERE warehouse_id = ?";

    if ($stmt = $conn->prepare($query)) {
        // Bind the warehouse_id to the prepared statement
        $stmt->bind_param('s', $warehouseId);

        // Execute the query
        if ($stmt->execute()) {
            echo "Warehouse deleted successfully.";
        } else {
            echo "Error deleting warehouse.";
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
