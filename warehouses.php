<?php
// Include database connection file
include('connect.php');

// Fetch warehouses from the database
$query = "SELECT * FROM warehouses";
$result = $conn->query($query);

// Initialize an array to store the fetched warehouses
$warehouses = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $warehouses[] = $row;
    }
} else {
    // If no warehouses found, return an empty array
    $warehouses = [];
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warehouses - Inventory Management System</title>


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
    <!-- Leaflet CSS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css">
    <!-- AdminLTE Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <style>
        #warehouse-map {
            height: 400px;
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

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">Inventory System</span>
        </a>
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
                        <a href="warehouses.php" class="nav-link active">
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
                        <a href="storage.php" class="nav-link">
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
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Log Out</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Warehouses</h1>
                    </div>
                </div>
            </div>
        </section>

<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <!-- Warehouse Inventory Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Warehouse Inventory</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addWarehouseModal">
                        <i class="fas fa-plus"></i> Add Warehouse
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects" id="warehouseTable">
                    <thead>
                        <tr>
                            <th style="width: 10%">Warehouse ID</th>
                            <th style="width: 15%">Warehouse Name</th>
                            <th style="width: 20%">Location</th>
                            <th style="width: 15%">Capacity</th>
                            <th style="width: 10%">Stock Level</th>
                            <th style="width: 30%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($warehouses as $warehouse): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($warehouse['warehouse_id']); ?></td>
                                    <td><?php echo htmlspecialchars($warehouse['warehouse_name']); ?></td>
                                    <td><?php echo htmlspecialchars($warehouse['location']); ?></td>
                                    <td><?php echo htmlspecialchars($warehouse['capacity']); ?></td>
                                    <td><?php echo htmlspecialchars($warehouse['stock_level']); ?></td>
                                    <td>
                                        <!-- View Button -->
                                        <button class="btn btn-info" 
                                            data-toggle="modal" 
                                            data-target="#viewWarehouseModal" 
                                            data-id="<?php echo $warehouse['warehouse_id']; ?>"
                                            data-name="<?php echo $warehouse['warehouse_name']; ?>"
                                            data-location="<?php echo $warehouse['location']; ?>"
                                            data-capacity="<?php echo $warehouse['capacity']; ?>"
                                            data-stock="<?php echo $warehouse['stock_level']; ?>">View
                                        </button>
                                        <!-- Edit Button -->
                                        <button class="btn btn-warning" 
                                            data-toggle="modal" 
                                            data-target="#editWarehouseModal" 
                                            data-id="<?php echo $warehouse['warehouse_id']; ?>"
                                            data-name="<?php echo $warehouse['warehouse_name']; ?>"
                                            data-location="<?php echo $warehouse['location']; ?>"
                                            data-capacity="<?php echo $warehouse['capacity']; ?>"
                                            data-stock="<?php echo $warehouse['stock_level']; ?>">Edit
                                        </button>
                                        <!-- Delete Button -->
                                        <button class="btn btn-danger" 
                                            data-toggle="modal" 
                                            data-target="#deleteWarehouseModal" 
                                            data-id="<?php echo $warehouse['warehouse_id']; ?>">Delete
                                        </button>


                                        <!-- View on Map Button -->
                                        <button class="btn btn-info view-btn" 
                                            data-id="<?php echo $warehouse['warehouse_id']; ?>">View on Map
                                        </button>




                                    </td>
                                </tr>
                            <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Map Section -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Warehouse Locations Map</h3>
            </div>
            <div class="card-body">
                <div id="warehouse-map" style="height: 400px;"></div>
            </div>
        </div>
    </div>
</section>


        <!-- Footer -->
        <footer class="main-footer">
            <strong>&copy; 2024 <a href="#">Inventory Management System for Perishable Goods</a>.</strong>
            All rights reserved.
        </footer>
    </div>
</div>


<!-- Add Warehouse Modal -->
<div class="modal fade" id="addWarehouseModal" tabindex="-1" role="dialog" aria-labelledby="addWarehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addWarehouseModalLabel">Add New Warehouse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add-warehouse.php" method="POST">
                    <div class="form-group">
                        <label for="warehouseId">Warehouse ID</label>
                        <input type="text" class="form-control" name="warehouse_id" id="warehouseId" required>
                    </div>
                    <div class="form-group">
                        <label for="warehouseName">Warehouse Name</label>
                        <input type="text" class="form-control" name="warehouse_name" id="warehouseName" required>
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" name="location" id="location" required>
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" class="form-control" name="capacity" id="capacity" required>
                    </div>
                    <div class="form-group">
                        <label for="stockLevel">Stock Level</label>
                        <input type="number" class="form-control" name="stock_level" id="stockLevel" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Warehouse</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Delete Warehouse Modal -->
<div class="modal fade" id="deleteWarehouseModal" tabindex="-1" role="dialog" aria-labelledby="deleteWarehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteWarehouseModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this warehouse?</p>
                <input type="hidden" id="warehouseIdToDelete">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteWarehouseButton" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>


<!-- Edit Warehouse Modal -->
<div class="modal fade" id="editWarehouseModal" tabindex="-1"  aria-labelledby="editWarehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWarehouseModalLabel">Edit Warehouse</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editWarehouseForm">
                    <input type="hidden" id="editWarehouseId" name="warehouse_id">
                    <div class="form-group">
                        <label for="editWarehouseName">Warehouse Name</label>
                        <input type="text" class="form-control" id="editWarehouseName" name="warehouse_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editLocation">Location</label>
                        <input type="text" class="form-control" id="editLocation" name="location" required>
                    </div>
                    <div class="form-group">
                        <label for="editCapacity">Capacity</label>
                        <input type="number" class="form-control" id="editCapacity" name="capacity" required>
                    </div>
                    <div class="form-group">
                        <label for="editStockLevel">Stock Level</label>
                        <input type="number" class="form-control" id="editStockLevel" name="stock_level" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="saveEditWarehouseButton" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </div>
</div>


<!-- View Warehouse Modal -->
<div class="modal fade" id="viewWarehouseModal" tabindex="-1" role="dialog" aria-labelledby="viewWarehouseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewWarehouseModalLabel">Warehouse Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Warehouse Name:</strong> <span id="viewWarehouseName"></span></p>
                <p><strong>Location:</strong> <span id="viewWarehouseLocation"></span></p>
                <p><strong>Capacity:</strong> <span id="viewWarehouseCapacity"></span></p>
                <p><strong>Stock Level:</strong> <span id="viewWarehouseStockLevel"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Embed Warehouses Data -->
<script>
    const warehouses = <?php echo json_encode($warehouses); ?>;
</script>



<!-- Scripts -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<!-- <script src="warehouses.js"></script> -->


<script>



    // View Warehouse Modal
    
    $('#viewWarehouseModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var name = button.data('name'); // Extract warehouse details from data-* attributes
        var location = button.data('location');
        var capacity = button.data('capacity');
        var stockLevel = button.data('stock');

        var modal = $(this);
        modal.find('#viewWarehouseName').text(name);
        modal.find('#viewWarehouseLocation').text(location);
        modal.find('#viewWarehouseCapacity').text(capacity);
        modal.find('#viewWarehouseStockLevel').text(stockLevel);
    });

    // Delete Warehouse Modal
    // When the modal is about to be shown
    $('#deleteWarehouseModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var warehouseId = button.data('id'); // Extract the warehouse_id from data-* attribute
        var modal = $(this);

        // Set the hidden input value with the warehouse_id
        modal.find('#warehouseIdToDelete').val(warehouseId);
    });

    // When the delete button is clicked in the modal
    $('#confirmDeleteWarehouseButton').click(function () {
        var warehouseId = $('#warehouseIdToDelete').val(); // Get the warehouse_id

        // Send an AJAX request to delete the warehouse
        $.ajax({
            type: "POST",
            url: "delete-warehouse.php", // PHP script to handle deletion
            data: { warehouse_id: warehouseId },
            success: function (response) {
                // Close the modal
                $('#deleteWarehouseModal').modal('hide');
                
                // Reload the page or update the UI as needed
                alert(response); // Display the response
                location.reload(); // Reload the page to reflect changes
            },
            error: function () {
                alert('Error deleting warehouse.');
            }
        });
    });

    // Edit Warehouse Modal
    // When the edit modal is about to be shown
    $('#editWarehouseModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var warehouseId = button.data('id'); // Extract warehouse data from data-* attributes
        var warehouseName = button.data('name');
        var location = button.data('location');
        var capacity = button.data('capacity');
        var stockLevel = button.data('stock');

        // Set the values in the modal fields
        $('#editWarehouseId').val(warehouseId);
        $('#editWarehouseName').val(warehouseName);
        $('#editLocation').val(location);
        $('#editCapacity').val(capacity);
        $('#editStockLevel').val(stockLevel);
    });

    // When the save button is clicked in the modal
    $('#saveEditWarehouseButton').click(function () {
        // Serialize the form data
        var formData = $('#editWarehouseForm').serialize();

        // Send an AJAX request to update the warehouse
        $.ajax({
            type: "POST",
            url: "update-warehouse.php", // PHP script to handle the update
            data: formData,
            success: function (response) {
                // Close the modal
                $('#editWarehouseModal').modal('hide');

                // Reload the page or update the UI as needed
                alert(response); // Display the response
                location.reload(); // Reload the page to reflect changes
            },
            error: function () {
                alert('Error updating warehouse.');
            }
        });
    });







    // Initialize the map with a default center and zoom level
    const map = L.map("warehouse-map").setView([37.7749, -122.4194], 5);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
    }).addTo(map);

    let markers = {}; // Store markers by warehouse ID

    // Render all markers on the map
    function renderMarkers() {
        // Remove existing markers
        Object.values(markers).forEach((marker) => map.removeLayer(marker));
        markers = {}; // Clear marker storage

        warehouses.forEach((warehouse) => {
            const [lat, lng] = warehouse.location.split(",").map(Number);

            // Create a marker and bind a popup
            const marker = L.marker([lat, lng])
                .addTo(map)
                .bindPopup(`<b>${warehouse.warehouse_name}</b><br>Stock: ${warehouse.stock_level}`);

            // Store the marker using the warehouse ID
            markers[warehouse.warehouse_id] = marker;
        });
    }

    // Attach click events to all "View on Map" buttons
    function attachViewActions() {
        document.querySelectorAll(".view-btn").forEach((button) => {
            button.addEventListener("click", (e) => {
                const id = e.target.getAttribute("data-id"); // Get warehouse ID from button
                const warehouse = warehouses.find((wh) => wh.warehouse_id == id); // Find the warehouse by ID

                if (warehouse) {
                    const [lat, lng] = warehouse.location.split(",").map(Number);

                    // Zoom and center the map on the selected warehouse
                    map.setView([lat, lng], 14); // Adjust the zoom level as needed

                    // Highlight the marker and open its popup
                    if (markers[warehouse.warehouse_id]) {
                        markers[warehouse.warehouse_id].openPopup(); // Open the popup for the marker
                    }
                }
            });
        });
    }

    // Render the markers and attach actions to buttons
    renderMarkers();
    attachViewActions();


</script>







</body>
</html>
