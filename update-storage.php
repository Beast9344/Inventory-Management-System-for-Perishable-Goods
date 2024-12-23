<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $storageId = $_POST['storage_id'];
    $storageName = $_POST['storage_name'];
    $capacity = $_POST['capacity'];
    $usedCapacity = $_POST['used_capacity'];

    // SQL query to update the storage item
    $sql = "UPDATE storage SET 
            storage_name = ?, 
            capacity = ?, 
            used_capacity = ? 
            WHERE storage_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siis", $storageName, $capacity, $usedCapacity, $storageId);

    if ($stmt->execute()) {
        echo "Storage item updated successfully.";
    } else {
        echo "Error updating storage item: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
