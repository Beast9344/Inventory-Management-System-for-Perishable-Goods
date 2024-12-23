<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $alertType = $_POST['alert_type'];
    $description = $_POST['description'];
    $alertDate = $_POST['alert_date'];
    $status = $_POST['status'];

    // Insert the alert into the database
    $sql = "INSERT INTO alerts (alert_type, description, alert_date, status) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $alertType, $description, $alertDate, $status);

    if ($stmt->execute()) {
        echo "Alert added successfully.";

        // Redirect to the alerts page after successful insertion
        header("Location: alerts.php");
        exit(); // Stop further script execution
    } else {
        echo "Error adding alert: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
