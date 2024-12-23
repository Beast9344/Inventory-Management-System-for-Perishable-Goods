<?php
// Include database connection file
include('connect.php');

// Fetch grouped order_items from the database
$query = "
    SELECT 
        order_id, 
        GROUP_CONCAT(product_name SEPARATOR ', ') AS product_names,
        SUM(price * quantity) AS subtotal,
        MAX(total) AS total,
        payment_method,
        MAX(order_date) AS order_date
    FROM order_items
    GROUP BY order_id
    ORDER BY order_date DESC
";
$result = $conn->query($query);

// Initialize an array to store the grouped order items
$order_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $order_items[] = $row;
    }
} else {
    $order_items = [];
}

// Close the database connection
$conn->close();
?>




<!-- Use SQL's GROUP_CONCAT function to combine product names into a single column and aggregate totals, subtotals, and other necessary fields. -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Orders - Consumer Dashboard</title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Bootstrap 4 -->









    <style>
        .order-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .order-table th, .order-table td {
            vertical-align: middle;
        }
        .order-actions button {
            margin-right: 5px;
            transition: transform 0.2s ease;
        }
        .order-actions button:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="D_Customer_products.php" class="nav-link">Home</a>
                </li>
            </ul>
        </nav>
        
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Consumer Dashboard</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="D_Customer_products.php" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="D_Customer_cart.html" class="nav-link ">
                                <i class="nav-icon fas fa-shopping-cart"></i>
                                <p>My Cart</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="D_My-Order.php" class="nav-link active">
                                <i class="nav-icon fas fa-file-invoice"></i>
                                <p>My Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="login.html" class="nav-link">
                                <i class="nav-icon fas fa-sign-in-alt"></i>
                                <p>Log Out</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>


        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>My Orders</h1>
                        </div>
                    </div>
                </div>
            </section>






            
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title"><i class="fas fa-file-invoice"></i> Order History</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered order-table">
                                <thead>
                                    <tr>

                                        <th>Order ID</th>
                                        <th>Product Name</th>
                                        <th>Subtotal</th>
                                        <th>Total</th>
                                        <th>Payment Method</th>
                                        <th>Date</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>



                                <tbody>
                                    <?php foreach ($order_items as $item): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['order_id']); ?></td>
                                            <td><?php echo htmlspecialchars($item['product_names']); ?></td>                     
                                            <td>$<?php echo htmlspecialchars(number_format($item['subtotal'], 2)); ?></td>
                                            <td>$<?php echo htmlspecialchars(number_format($item['total'], 2)); ?></td>
                                            <td><?php echo htmlspecialchars($item['payment_method']); ?></td>
                                            <td><?php echo htmlspecialchars(date('F j, Y, g:i A', strtotime($item['order_date']))); ?></td>


                                            <td class="order-actions">
                                                <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#orderDetailsModal" data-order-id="<?php echo $item['order_id']; ?>">
                                                    View Details
                                                </button>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>




                            </table>
                        </div>
                    </div>
                </div>
            </section>




        </div>
    </div>



<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Order ID:</strong> <span id="modalOrderId"></span></p>
                <p><strong>Product Names:</strong> <span id="modalProductNames"></span></p>
                <p><strong>Subtotal:</strong> $<span id="modalSubtotal"></span></p>
                <p><strong>Total:</strong> $<span id="modalTotal"></span></p>
                <p><strong>Payment Method:</strong> <span id="modalPaymentMethod"></span></p>
                <p><strong>Order Date:</strong> <span id="modalOrderDate"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Footer -->
<footer class="main-footer">
    <strong>&copy; 2024 <a href="https://google.com">Inventory Management System for Perishable Goods</a>.</strong>
    All rights reserved.
</footer>



    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>















    <script>



// View Order Details Modal
$('#orderDetailsModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var orderId = button.data('order-id');

    // Fetch the row data
    var row = button.closest('tr');
    var productNames = row.find('td:nth-child(2)').text();
    var subtotal = row.find('td:nth-child(3)').text().replace('$', '');
    var total = row.find('td:nth-child(4)').text().replace('$', '');
    var paymentMethod = row.find('td:nth-child(5)').text();
    var orderDate = row.find('td:nth-child(6)').text();

    // Populate the modal
    var modal = $(this);
    modal.find('#modalOrderId').text(orderId);
    modal.find('#modalProductNames').text(productNames);
    modal.find('#modalSubtotal').text(subtotal);
    modal.find('#modalTotal').text(total);
    modal.find('#modalPaymentMethod').text(paymentMethod);
    modal.find('#modalOrderDate').text(orderDate);
});









    </script>





</body>
</html>















