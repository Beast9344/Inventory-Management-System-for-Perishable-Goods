<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $warehouseId = $_POST['warehouse_id'];
    $warehouseName = $_POST['warehouse_name'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $stockLevel = $_POST['stock_level'];

    // SQL query to update the warehouse
    $sql = "UPDATE warehouses SET 
            warehouse_name = ?, 
            location = ?, 
            capacity = ?, 
            stock_level = ? 
            WHERE warehouse_id = ?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiis", $warehouseName, $location, $capacity, $stockLevel, $warehouseId);

    if ($stmt->execute()) {
        echo "Warehouse updated successfully.";
    } else {
        echo "Error updating warehouse: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
