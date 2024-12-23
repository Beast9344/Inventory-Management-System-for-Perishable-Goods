<?php
// Include database connection file
include('connect.php');

// Fetch storage data from the database
$query = "SELECT * FROM storage";
$result = $conn->query($query);

// Initialize an array to store the fetched storage data
$storage = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $storage[] = $row;
    }
} else {
    // If no storage found, return an empty array
    $storage = [];
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Storage Monitoring - Inventory Management System</title>

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




    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Arial", sans-serif;
    }

    body {
    background: linear-gradient(135deg, #f0f4ff, #f7f0ff);
    }

    /* Main Content Styles */
    .content-wrapper {
    padding: 5px 20px;
    }

    .row {
    padding: 20px 0px;
    }

    /* Card Styles */
    .card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-top: 4px solid #6366f1;
    width: 100%;
    margin: 0 auto;
    }

    .primary-storage-section {
    padding: 20px 0px;
    }

    .storage-header {
    padding: 20px 0px;
    margin-bottom: 20px;
    }

    .status-icon {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    margin-right: 10px;
    }

    .healthy {
    background: #10b981;
    }

    .warning {
    background: #f59e0b;
    }

    .progress-bar {
    background: #f3f4f6;
    height: 20px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 10px;
    }

    .progress {
    height: 100%;
    transition: width 0.3s;
    background: linear-gradient(90deg, #6366f1, #4f46e5);
    }

    .metrics-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 15px;
    margin: 20px 0;
    }

    .metric-box {
    background: linear-gradient(135deg, #f0f7ff, #e0e7ff);
    padding: 15px;
    border-radius: 8px;
    display: flex;
    gap: 30px;
    font-size: 26px;
    justify-content: space-between;
    }

    .inventory-grid {
    display: grid;
    gap: 10px;
    margin: 20px 0;
    }

    .inventory-item {
    background: linear-gradient(135deg, #f5f3ff, #ede9fe);
    padding: 10px;
    border-radius: 8px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    }

    .add-form {
    display: flex;
    gap: 10px;
    margin-top: 20px;
    }

    input,
    select {
    padding: 8px;
    border: 1px solid #e5e7eb;
    border-radius: 5px;
    }

    button {
    background: linear-gradient(135deg, #6366f1, #4f46e5);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.2s;
    }

    button:hover {
    opacity: 0.9;
    }

    .edit-btn {
    background: #3b82f6;
    margin-right: 5px;
    padding: 6px 12px;
    }

    .remove-btn {
    background: #ef4444;
    padding: 6px 12px;
    }

    .item-controls {
    display: flex;
    gap: 5px;
    }

    /* Alert Styles */
    .alert {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    border-radius: 5px;
    color: white;
    z-index: 1000;
    animation: slideIn 0.3s ease-out;
    }

    .alert-success {
    background: linear-gradient(135deg, #10b981, #059669);
    }

    .alert-error {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    @keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
    }

    h4 {
    margin-bottom: 10px;
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
                <a href="dashboard.php" class="nav-link">Home</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

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
                        <a href="dashboard.php" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="orders.php" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Sales Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="Customer_Order.php" class="nav-link ">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>Customer Order</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="products.php" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="warehouses.php" class="nav-link ">
                            <i class="nav-icon fas fa-warehouse"></i>
                            <p>Warehouses</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="employees.php" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Employees</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="alerts.php" class="nav-link">
                            <i class="nav-icon fas fa-exclamation-triangle"></i>
                            <p>Alerts</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="storage.php" class="nav-link active">
                            <i class="nav-icon fas fa-thermometer-half"></i>
                            <p>Storage Monitoring</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="users.php" class="nav-link  ">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Users </p>
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
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Storage Monitoring</h1>
                    </div>
                </div>
            </div>
        </section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Real-Time Monitoring Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Real-Time Storage Conditions</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Temperature Monitoring -->
                    <div class="col-lg-6 col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-thermometer-half"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Temperature</span>
                                <span class="info-box-number" id="temperature-value">-- °C</span>
                            </div>
                        </div>
                    </div>
                    <!-- Humidity Monitoring -->
                    <div class="col-lg-6 col-md-6">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-tint"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Humidity</span>
                                <span class="info-box-number" id="humidity-value">-- %</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-muted">Last updated: <span id="last-updated">--</span></div>
            </div>
        </div>

        <!-- Alerts Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-exclamation-triangle"></i> Alerts</h3>
                    </div>
                    <div class="card-body">
                        <ul id="alerts-list" class="list-unstyled">
                            <!-- Dynamic Alerts will be inserted here -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>




        <!-- Storage Sections -->
        <section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Storage Monitoring</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addStorageModal">
                        <i class="fas fa-plus"></i> Add Storage
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects" id="storageTable">
                    <thead>
                        <tr>
                            <th style="width: 10%">Storage ID</th>
                            <th style="width: 20%">Storage Name</th>
                            <th style="width: 15%">Capacity (kg)</th>
                            <th style="width: 15%">Used Capacity</th>
                            <th style="width: 20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($storage as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['storage_id']); ?></td>
                            <td><?php echo htmlspecialchars($item['storage_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['capacity']); ?> kg</td>
                            <td><?php echo htmlspecialchars($item['used_capacity']); ?> kg</td>
                            <td>
                                <!-- View Button -->
                                <button class="btn btn-info" 
                                    data-toggle="modal" 
                                    data-target="#viewStorageModal" 
                                    data-id="<?php echo $item['storage_id']; ?>"
                                    data-name="<?php echo $item['storage_name']; ?>"
                                    data-capacity="<?php echo $item['capacity']; ?>"
                                    data-usedcapacity="<?php echo $item['used_capacity']; ?>">View
                                </button>


                                <!-- Edit Button -->
                                <button class="btn btn-warning" 
                                    data-toggle="modal" 
                                    data-target="#editStorageModal" 
                                    data-id="<?php echo $item['storage_id']; ?>"
                                    data-name="<?php echo $item['storage_name']; ?>"
                                    data-capacity="<?php echo $item['capacity']; ?>"
                                    data-used="<?php echo $item['used_capacity']; ?>">Edit
                                </button>


                                <!-- Delete Button -->
                                <button class="btn btn-danger" 
                                    data-toggle="modal" 
                                    data-target="#deleteStorageModal" 
                                    data-id="<?php echo $item['storage_id']; ?>">Delete
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
</section>






    <!-- Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2024 <a href="https://google.com">Inventory Management System for Perishable Goods</a>.</strong>
        All rights reserved.
    </footer>


    </div>
    <!-- /.content-wrapper -->


</div>
<!-- ./wrapper -->


<!-- Add Storage Modal -->
<div class="modal fade" id="addStorageModal" tabindex="-1" role="dialog" aria-labelledby="addStorageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStorageModalLabel">Add New Storage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add-storage.php" method="POST">
                    <div class="form-group">
                        <label for="storageId">Storage ID</label>
                        <input type="text" class="form-control" name="storage_id" id="storageId" required>
                    </div>
                    <div class="form-group">
                        <label for="storageName">Storage Name</label>
                        <input type="text" class="form-control" name="storage_name" id="storageName" required>
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity (kg)</label>
                        <input type="number" class="form-control" name="capacity" id="capacity" required>
                    </div>
                    <div class="form-group">
                        <label for="usedCapacity">Used Capacity (kg)</label>
                        <input type="number" class="form-control" name="used_capacity" id="usedCapacity" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Storage</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Edit Storage Modal -->
<div class="modal fade" id="editStorageModal" tabindex="-1" aria-labelledby="editStorageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStorageModalLabel">Edit Storage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editStorageForm">
                    <input type="hidden" id="editStorageId" name="storage_id">
                    <div class="form-group">
                        <label for="editStorageName">Storage Name</label>
                        <input type="text" class="form-control" id="editStorageName" name="storage_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editCapacity">Capacity (kg)</label>
                        <input type="number" class="form-control" id="editCapacity" name="capacity" required>
                    </div>
                    <div class="form-group">
                        <label for="editUsedCapacity">Used Capacity (kg)</label>
                        <input type="number" class="form-control" id="editUsedCapacity" name="used_capacity" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="saveEditButton" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- Delete Storage Modal -->
<div class="modal fade" id="deleteStorageModal" tabindex="-1" aria-labelledby="deleteStorageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStorageModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this storage?</p>
                <input type="hidden" id="storageIdToDelete">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>


<!-- View Storage Modal -->
<div class="modal fade" id="viewStorageModal" tabindex="-1" role="dialog" aria-labelledby="viewStorageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewStorageModalLabel">Storage Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Storage Name:</strong> <span id="viewStorageName"></span></p>
                <p><strong>Capacity:</strong> <span id="viewStorageCapacity"></span> kg</p>
                <p><strong>Used Capacity:</strong> <span id="viewStorageUsedCapacity"></span> kg</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>














<!-- Real-Time Monitoring Script -->
<script>
    // Simulating real-time updates
    setInterval(() => {
        const temp = (20 + Math.random() * 10).toFixed(2); // Simulated temperature
        const humidity = (40 + Math.random() * 20).toFixed(2); // Simulated humidity
        const now = new Date().toLocaleString();

        // Update the display
        document.getElementById('temperature-value').innerText = `${temp} °C`;
        document.getElementById('humidity-value').innerText = `${humidity} %`;
        document.getElementById('last-updated').innerText = now;

        // Manage alerts
        const alertsList = document.getElementById('alerts-list');
        alertsList.innerHTML = ''; // Clear old alerts

        // Threshold checks
        if (temp > 28) {
            const tempAlert = `<li><strong>Warning:</strong> Temperature is above safe levels! (${temp} °C)</li>`;
            alertsList.innerHTML += tempAlert;
        }
        if (humidity < 45) {
            const humidityAlert = `<li><strong>Warning:</strong> Humidity is below safe levels! (${humidity} %)</li>`;
            alertsList.innerHTML += humidityAlert;
        }
    }, 5000);










// View Storage Modal
$('#viewStorageModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract data attributes
    var name = button.data('name');
    var capacity = button.data('capacity');
    var usedCapacity = button.data('usedcapacity'); // Correct attribute name

    // Update the modal with the extracted data
    var modal = $(this);
    modal.find('#viewStorageName').text(name);
    modal.find('#viewStorageCapacity').text(capacity);
    modal.find('#viewStorageUsedCapacity').text(usedCapacity); // Correctly set used capacity
});


// Delete Storage Modal
$('#deleteStorageModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var storageId = button.data('id'); // Extract the storage_id from data-* attribute
    var modal = $(this);

    // Set the hidden input value with the storage_id
    modal.find('#storageIdToDelete').val(storageId);
});

// When the delete button is clicked in the modal
$('#confirmDeleteButton').click(function () {
    var storageId = $('#storageIdToDelete').val(); // Get the storage_id

    // Send an AJAX request to delete the storage
    $.ajax({
        type: "POST",
        url: "delete-storage.php", // PHP script to handle deletion
        data: { storage_id: storageId },
        success: function (response) {
            // Close the modal
            $('#deleteStorageModal').modal('hide');
            
            // Reload the page or update the UI as needed
            alert(response); // Display the response
            location.reload(); // Reload the page to reflect changes
        },
        error: function () {
            alert('Error deleting storage.');
        }
    });
});




// When the edit modal is about to be shown
// When the edit modal is about to be shown
$('#editStorageModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var storageId = button.data('id'); // Extract storage data from data-* attributes
    var storageName = button.data('name');
    var capacity = button.data('capacity');
    var usedCapacity = button.data('used'); // Corrected from 'usedcapacity' to 'used'

    // Set the values in the modal fields
    $('#editStorageId').val(storageId);
    $('#editStorageName').val(storageName);
    $('#editCapacity').val(capacity);
    $('#editUsedCapacity').val(usedCapacity);
});

// When the save button is clicked in the modal
$('#saveEditButton').click(function () {
    // Serialize the form data
    var formData = $('#editStorageForm').serialize();

    // Send an AJAX request to update the storage
    $.ajax({
        type: "POST",
        url: "update-storage.php", // PHP script to handle the update
        data: formData,
        success: function (response) {
            // Close the modal
            $('#editStorageModal').modal('hide');

            // Reload the page or update the UI as needed
            alert(response); // Display the response
            location.reload(); // Reload the page to reflect changes
        },
        error: function () {
            alert('Error updating storage.');
        }
    });
});








</script>




</body>
</html>
