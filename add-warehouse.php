<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $warehouseId = $_POST['warehouse_id'];
    $warehouseName = $_POST['warehouse_name'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];
    $stockLevel = $_POST['stock_level'];

    // Insert the warehouse into the database
    $sql = "INSERT INTO warehouses (warehouse_id, warehouse_name, location, capacity, stock_level) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $warehouseId, $warehouseName, $location, $capacity, $stockLevel);

    if ($stmt->execute()) {
        echo "Warehouse added successfully.";

        // Redirect to warehouses.php after successful insertion
        header("Location: warehouses.php");
        exit();
    } else {
        echo "Error adding warehouse: " . $stmt->error;
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>
