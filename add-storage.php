<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $storageId = $_POST['storage_id'];
    $storageName = $_POST['storage_name'];
    $capacity = $_POST['capacity'];
    $usedCapacity = $_POST['used_capacity'];

    // Insert the storage item into the database
    $sql = "INSERT INTO storage (storage_id, storage_name, capacity, used_capacity) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssii", $storageId, $storageName, $capacity, $usedCapacity);

    if ($stmt->execute()) {
        echo "Storage item added successfully.";
        header("Location: storage.php"); // Redirect after successful insertion
        exit();
    } else {
        echo "Error adding storage item: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
