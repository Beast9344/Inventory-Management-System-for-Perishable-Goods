<?php
// Include database connection file
include('connect.php');

// Check if alert_id is set and is valid
if (isset($_POST['alert_id'])) {
    $alertId = $_POST['alert_id'];

    // Prepare the DELETE query
    $query = "DELETE FROM alerts WHERE alert_id = ?";
    
    if ($stmt = $conn->prepare($query)) {
        // Bind the alert_id to the prepared statement
        $stmt->bind_param('i', $alertId);

        // Execute the query
        if ($stmt->execute()) {
            echo "Alert deleted successfully.";
        } else {
            echo "Error deleting alert.";
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
