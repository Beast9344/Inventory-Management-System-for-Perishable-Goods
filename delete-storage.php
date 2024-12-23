<?php
// Include database connection file
include('connect.php');

// Check if storage_id is set and valid
if (isset($_POST['storage_id'])) {
    $storageId = $_POST['storage_id'];

    // Prepare the DELETE query
    $query = "DELETE FROM storage WHERE storage_id = ?";

    if ($stmt = $conn->prepare($query)) {
        // Bind the storage_id to the prepared statement
        $stmt->bind_param('s', $storageId);

        // Execute the query
        if ($stmt->execute()) {
            echo "Storage item deleted successfully.";
        } else {
            echo "Error deleting storage item.";
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
