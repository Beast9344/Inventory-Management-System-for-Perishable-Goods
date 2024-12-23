<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $orderId = $_POST['order_id'];
    $customerName = $_POST['customer_name'];
    $orderDate = $_POST['order_date'];
    $status = $_POST['status'];
    $totalAmount = $_POST['total_amount'];

    // Insert the order into the database
    $sql = "INSERT INTO orders (order_id, customer_name, order_date, status, total_amount) 
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssd", $orderId, $customerName, $orderDate, $status, $totalAmount);

    if ($stmt->execute()) {
        echo "Order added successfully.";

        // Redirect to orders.php after successful insertion
        header("Location: orders.php");
        exit(); // Stop further script execution
    } else {
        echo "Error adding order: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
}
?>
