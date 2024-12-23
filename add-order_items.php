<?php
// Include database connection file
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the POST data
    $orderId = $_POST['order_id'];
    $cart = json_decode($_POST['cart'], true); // Decode the JSON cart
    $paymentMethod = $_POST['payment_method'];
    $total = $_POST['total'];
    
    if (empty($cart) || empty($orderId) || empty($paymentMethod) || empty($total)) {
        die("Invalid input data.");
    }

    $conn->begin_transaction(); // Start transaction

    try {
        foreach ($cart as $item) {
            $productName = $item['name'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $subtotal = $price * $quantity;

            // Prepare SQL statement
            $sql = "INSERT INTO order_items (order_id, product_name, price, quantity, subtotal, payment_method, total) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("isdidsd", $orderId, $productName, $price, $quantity, $subtotal, $paymentMethod, $total);

            if (!$stmt->execute()) {
                throw new Exception("Error adding item: " . $stmt->error);
            }
        }

        $conn->commit(); // Commit the transaction
        echo "Order processed successfully.";
    } catch (Exception $e) {
        $conn->rollback(); // Roll back the transaction on error
        echo "Transaction failed: " . $e->getMessage();
    } finally {
        $stmt->close();
        $conn->close();
    }
}
?>
