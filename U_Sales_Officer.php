<?php
// Include database connection file
include('connect.php');

// Fetch orders from the database
$query = "SELECT * FROM orders";
$result = $conn->query($query);

// Initialize an array to store the fetched orders
$orders = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
} else {
    // If no orders found, return an empty array
    $orders = [];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales Orders - Inventory Management System</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">



    <style>


body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
}

    .content-wrapper {
        margin-left: 50px;
        padding: 20px;
        }

/* Search Container */
.search-container {
    background: linear-gradient(to right, #f27121, #e94057);
    color: #fff;
    border-radius: 5px;
    padding: 20px;
}

.search-container input {
    margin-bottom: 10px;
}

.search-container button {
    background-color: #fff;
    color: #e94057;
    font-weight: bold;
}

/* Category Buttons */
.category-container button {
    width: 150px;
    margin-right: 10px;
    font-size: 14px;
}

/* Order Table */
table {
    width: 100%;
    border-collapse: collapse;
    background-color: #ffffff;
    border-radius: 5px;
    overflow: hidden;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

table thead th {
    background-color: #6a11cb;
    color: #ffffff;
    padding: 10px;
    text-align: left;
}

table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tbody tr:hover {
    background-color: #eaeaea;
}

table tbody td {
    padding: 10px;
    text-align: left;
}

/* Buttons for Actions */
.actions button {
    margin-right: 5px;
    font-size: 12px;
    padding: 5px 10px;
}

.actions .btn-info {
    background-color: #17a2b8;
    color: #ffffff;
}

.actions .btn-warning {
    background-color: #ffc107;
    color: #ffffff;
}

.actions .btn-danger {
    background-color: #dc3545;
    color: #ffffff;
}




    /* Ensure the wrapper takes full height */
    html, body {
        height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }

    /* Main wrapper to flex and grow */
    .wrapper {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    /* Content wrapper should grow to fill available space */
    .content-wrapper {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    /* Footer styles to stay at the bottom */
    footer {
        background: #f8f9fa; /* Light background for the footer */
        text-align: center;
        padding: 10px 20px;
        border-top: 1px solid #dee2e6;
        flex-shrink: 0;
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


            </ul>
        </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">Inventory System</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                  

                    <li class="nav-item">
                        <a href="U_Sales_Officer.php" class="nav-link active">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Sales Officer</p>
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
        <!-- /.sidebar -->
    </aside>


        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Sales Officer</h1>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">


                

                <div class="text-left mb-4">
                    <h1>Order Management</h1>
                    <p>Search and manage sales orders</p>
                </div>

                <!-- Search Container -->
                <div class="card search-container p-3 mb-3">
                    <h3>Search Sales Order</h3>
                    <input type="text" id="order-id" class="form-control mb-2" placeholder="Enter Order ID">
                    <button onclick="searchOrder()" class="btn btn-light">Search</button>
                </div>

                <!-- Filters -->
                <h3 class="mb-3">Filter by Status</h3>
                <div class="category-container d-flex justify-content-start mb-4">
                    <button class="btn btn-outline-primary me-2" onclick="filterByStatus('Pending')">Pending</button>
                    <button class="btn btn-outline-success me-2" onclick="filterByStatus('Completed')">Completed</button>
                    <button class="btn btn-outline-warning me-2" onclick="filterByStatus('Processing')">Processing</button>
                    <button class="btn btn-outline-danger me-2" onclick="filterByStatus('Cancelled')">Cancelled</button>
                    <button class="btn btn-outline-secondary" id="show-all-orders-btn">All Orders</button>
                </div>











                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Recent Sales Orders</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addOrderModal">
                                    <i class="fas fa-plus"></i> Add Sales Order
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped projects" id="salesOrdersTable">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Order ID</th>
                                        <th style="width: 20%">Customer Name</th>
                                        <th style="width: 15%">Order Date</th>
                                        <th style="width: 15%">Status</th>
                                        <th style="width: 15%">Total Amount</th>
                                        <th style="width: 25%">Actions</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php foreach ($orders as $order): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                                <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                                <td><?php echo htmlspecialchars($order['status']); ?></td>
                                                <td>$<?php echo number_format($order['total_amount'], 2); ?></td>
                                                <td>
                                                    <button class="btn btn-info" 
                                                        data-toggle="modal" 
                                                        data-target="#viewOrderModal" 
                                                        data-id="<?php echo $order['order_id']; ?>" 
                                                        data-customer="<?php echo htmlspecialchars($order['customer_name']); ?>"
                                                        data-date="<?php echo htmlspecialchars($order['order_date']); ?>"
                                                        data-status="<?php echo htmlspecialchars($order['status']); ?>"
                                                        data-amount="<?php echo htmlspecialchars($order['total_amount']); ?>">
                                                        View
                                                    </button>
                                                    <button class="btn btn-warning"
                                                        data-toggle="modal"
                                                        data-target="#editOrderModal"
                                                        data-id="<?php echo $order['order_id']; ?>"
                                                        data-customer="<?php echo htmlspecialchars($order['customer_name']); ?>"
                                                        data-date="<?php echo htmlspecialchars($order['order_date']); ?>"
                                                        data-status="<?php echo htmlspecialchars($order['status']); ?>"
                                                        data-amount="<?php echo htmlspecialchars($order['total_amount']); ?>">
                                                        Edit
                                                    </button>
                                                    <button class="btn btn-danger" 
                                                        data-toggle="modal" 
                                                        data-target="#deleteOrderModal" 
                                                        data-id="<?php echo $order['order_id']; ?>">
                                                        Delete
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

        <!-- Footer -->
        <footer class="main-footer">
            <strong>&copy; 2024 <a href="https://google.com">Inventory Management System for Perishable Goods</a>.</strong>
            All rights reserved.
        </footer>
    </div>

<!-- Add Order Modal -->
<div class="modal fade" id="addOrderModal" tabindex="-1" role="dialog" aria-labelledby="addOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOrderModalLabel">Add New Sales Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add-order.php" method="POST">
                    <div class="form-group">
                        <label for="orderId">Order ID</label>
                        <input type="text" class="form-control" name="order_id" id="orderId" required>
                    </div>
                    <div class="form-group">
                        <label for="customerName">Customer Name</label>
                        <input type="text" class="form-control" name="customer_name" id="customerName" required>
                    </div>
                    <div class="form-group">
                        <label for="orderDate">Order Date</label>
                        <input type="date" class="form-control" name="order_date" id="orderDate" required>
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" name="status" id="status" required>
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="totalAmount">Total Amount</label>
                        <input type="text" class="form-control" name="total_amount" id="totalAmount" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Order</button>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Edit Order Modal -->
<div id="editOrderModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editOrderModalLabel">Edit Order</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editOrderForm">
                    <input type="hidden" id="editOrderId" name="order_id">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editCustomerName">Customer Name</label>
                            <input type="text" class="form-control" id="editCustomerName" name="customer_name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editOrderDate">Order Date</label>
                            <input type="date" class="form-control" id="editOrderDate" name="order_date" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editStatus">Status</label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="Pending">Pending</option>
                                <option value="Processing">Processing</option>
                                <option value="Completed">Completed</option>
                                <option value="Cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editTotalAmount">Total Amount</label>
                            <input type="number" step="0.01" class="form-control" id="editTotalAmount" name="total_amount" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="saveEditButton" class="btn btn-warning">Save Changes</button>
            </div>
        </div>
    </div>
</div>



<!-- Delete Order Modal -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteOrderModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this sales order?</p>
                <input type="hidden" id="orderIdToDelete">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- View Order Modal -->
<!-- View Order Modal -->
<div id="viewOrderModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="viewOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewOrderModalLabel">View Order Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Order ID</h6>
                        <p id="viewOrderId" class="text-muted"></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Customer Name</h6>
                        <p id="viewCustomerName" class="text-muted"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Order Date</h6>
                        <p id="viewOrderDate" class="text-muted"></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Status</h6>
                        <p id="viewOrderStatus" class="text-muted"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h6>Total Amount</h6>
                        <p id="viewOrderAmount" class="text-muted"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





<!-- JS includes -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>



<script>





// Search Order by ID
function searchOrder() {
    var searchId = $('#order-id').val().trim();

    if (searchId === '') {
        alert('Please enter a valid Order ID.');
        return;
    }

    // Iterate through the table rows and find the matching ID
    $('#salesOrdersTable tbody tr').each(function () {
        var row = $(this);
        var orderId = row.find('td:first').text().trim();

        if (orderId === searchId) {
            row.show();
        } else {
            row.hide();
        }
    });
}

// Filter by Status
function filterByStatus(status) {
    $('#salesOrdersTable tbody tr').each(function () {
        var row = $(this);
        var orderStatus = row.find('td:nth-child(4)').text().trim();

        if (orderStatus === status) {
            row.show();
        } else {
            row.hide();
        }
    });
}

// Show All Orders
$('#show-all-orders-btn').click(function () {
    $('#salesOrdersTable tbody tr').show();
});










    // View Order Modal
    $('#viewOrderModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal

        // Extract data from data-* attributes
        var orderId = button.data('id');
        var customerName = button.data('customer');
        var orderDate = button.data('date');
        var status = button.data('status');
        var totalAmount = button.data('amount');

        // Populate the modal fields
        var modal = $(this);
        modal.find('#viewOrderId').text(orderId);
        modal.find('#viewCustomerName').text(customerName);
        modal.find('#viewOrderDate').text(orderDate);
        modal.find('#viewOrderStatus').text(status);
        modal.find('#viewOrderAmount').text(totalAmount);
    });

// Delete Order Modal
// When the delete modal is about to be shown
$('#deleteOrderModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var orderId = button.data('id'); // Extract the order_id from the data-* attribute
    var modal = $(this);

    // Set the hidden input value with the order_id
    modal.find('#orderIdToDelete').val(orderId);
});

// When the delete button is clicked in the modal
$('#confirmDeleteButton').click(function () {
    var orderId = $('#orderIdToDelete').val(); // Get the order_id

    // Send an AJAX request to delete the order
    $.ajax({
        type: "POST",
        url: "delete-order.php", // PHP script to handle deletion
        data: { order_id: orderId },
        success: function (response) {

            // Close the modal
            $('#deleteOrderModal').modal('hide');
            // Display the response message
            alert(response);

            // Reload the page to reflect changes
            location.reload();
        },
        error: function () {
            alert('Error deleting order.');
        }
    });

});


    

    // Edit Order Modal
 // When the edit modal is about to be shown
$('#editOrderModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract order data from data-* attributes
    var orderId = button.data('id');
    var customerName = button.data('customer');
    var orderDate = button.data('date');
    var status = button.data('status');
    var totalAmount = button.data('amount');

    // Set the values in the modal fields
    $('#editOrderId').val(orderId);
    $('#editCustomerName').val(customerName);
    $('#editOrderDate').val(orderDate);
    $('#editStatus').val(status);
    $('#editTotalAmount').val(totalAmount);
});

// When the save button is clicked in the modal
$('#saveEditButton').click(function () {
    // Serialize the form data
    var formData = $('#editOrderForm').serialize();

    // Send an AJAX request to update the order
    $.ajax({
        type: "POST",
        url: "update-order.php", // PHP script to handle the update
        data: formData,
        success: function (response) {

            // Close the modal
            $('#editOrderModal').modal('hide');
            // Display the response message
            alert(response);

            // Reload the page or update the UI to reflect changes
            location.reload(); // Refresh the page to fetch updated data
        },
        error: function () {
            alert('Error updating order.');
        }
    });


});










    // Add Order Modal
    $('#saveAddButton').click(function () {
        var formData = $('#addOrderForm').serializeArray(); // Serialize the form data
        var newRow = {
            order_id: formData.find(field => field.name === 'order_id').value,
            customer_name: formData.find(field => field.name === 'customer_name').value,
            order_date: formData.find(field => field.name === 'order_date').value,
            status: formData.find(field => field.name === 'status').value,
            total_amount: formData.find(field => field.name === 'total_amount').value,
        };

        // Simulate adding the new order to the table
        $('#salesOrdersTable tbody').append(`
            <tr>
                <td>${newRow.order_id}</td>
                <td>${newRow.customer_name}</td>
                <td>${newRow.order_date}</td>
                <td>${newRow.status}</td>
                <td>$${parseFloat(newRow.total_amount).toFixed(2)}</td>
                <td>
                    <button class="btn btn-info" data-toggle="modal" data-target="#viewOrderModal" data-id="${newRow.order_id}" data-customer="${newRow.customer_name}" data-date="${newRow.order_date}" data-status="${newRow.status}" data-amount="${newRow.total_amount}">
                        View
                    </button>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#editOrderModal" data-id="${newRow.order_id}" data-customer="${newRow.customer_name}" data-date="${newRow.order_date}" data-status="${newRow.status}" data-amount="${newRow.total_amount}">
                        Edit
                    </button>
                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteOrderModal" data-id="${newRow.order_id}">
                        Delete
                    </button>
                </td>
            </tr>
        `);

        // Close the modal
        $('#addOrderModal').modal('hide');

        // For debugging, show a confirmation message
        alert('New order has been added (simulated).');

        // Debugging message for backend issues
        console.error("Ensure your 'add-order.php' script handles insertion in the database correctly.");
    });
</script>

















</body>

</html>
