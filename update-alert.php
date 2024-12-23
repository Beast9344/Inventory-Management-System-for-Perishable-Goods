<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alertId = $_POST['alert_id'];
    $alertType = $_POST['alert_type'];
    $description = $_POST['description'];
    $alertDate = $_POST['alert_date'];
    $status = $_POST['status'];

    // SQL query to update the alert
    $sql = "UPDATE alerts SET 
            alert_type = ?, 
            description = ?, 
            alert_date = ?, 
            status = ? 
            WHERE alert_id = ?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $alertType, $description, $alertDate, $status, $alertId);

    if ($stmt->execute()) {
        echo "Alert updated successfully.";
    } else {
        echo "Error updating alert: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
