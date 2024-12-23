<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $customerName = $_POST['customer_name'];
    $orderDate = $_POST['order_date'];
    $status = $_POST['status'];
    $totalAmount = $_POST['total_amount'];

    // SQL query to update the order
    $sql = "UPDATE orders SET 
            customer_name = ?, 
            order_date = ?, 
            status = ?, 
            total_amount = ? 
            WHERE order_id = ?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssds", $customerName, $orderDate, $status, $totalAmount, $orderId);

    if ($stmt->execute()) {
        echo "Order updated successfully.";
    } else {
        echo "Error updating order: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
