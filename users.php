<?php
// Include database connection file
include('connect.php');

// Fetch users from the database
$query = "SELECT * FROM users";
$result = $conn->query($query);

// Initialize an array to store the fetched users
$users = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
} else {
    // If no users found, return an empty array
    $users = [];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users - Inventory Management System</title>

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
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>
    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        cursor: pointer;
    }
    .table-bordered th, .table-bordered td {
        border: 1px solid #dee2e6;
    }
    .badge {
        font-size: 0.9em;
        padding: 0.4em 0.6em;
    }
    .modal-content {
        border-radius: 10px;
    }
    .modal-header {
        background-color: #007bff;
        color: white;
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
        <a href="" class="brand-link">
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
                        <a href="products.php" class="nav-link ">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="warehouses.php" class="nav-link">
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
                        <a href="storage.php" class="nav-link ">
                            <i class="nav-icon fas fa-thermometer-half"></i>
                            <p>Storage Monitoring</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="users.php" class="nav-link active ">
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
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users Page</h1>
                </div>
            </div>
        </div>
    </section>



        <!-- Main content -->
        <section class="content">
        <div class="container mt-4">


                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="mb-0">User Management</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($users)): ?>
                                            <?php foreach ($users as $user): ?>
                                                <tr>
                                                    <td>
                                                        <i class="fas fa-user-circle text-primary"></i>
                                                        <?php echo htmlspecialchars($user['full_name']); ?>
                                                    </td>
                                                    <td>
                                                        <i class="fas fa-envelope text-secondary"></i>
                                                        <?php echo htmlspecialchars($user['email']); ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success">
                                                            <?php echo htmlspecialchars($user['role']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <button 
                                                            class="btn btn-outline-info btn-sm view-btn" 
                                                            data-name="<?php echo htmlspecialchars($user['full_name']); ?>" 
                                                            data-email="<?php echo htmlspecialchars($user['email']); ?>" 
                                                            data-role="<?php echo htmlspecialchars($user['role']); ?>">
                                                            <i class="fas fa-eye"></i> View
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No users found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

        </section>

        <!-- View User Modal -->
        <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewUserModalLabel">User Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><i class="fas fa-user"></i> <strong>Full Name:</strong> <span id="userName"></span></p>
                        <p><i class="fas fa-envelope"></i> <strong>Email:</strong> <span id="userEmail"></span></p>
                        <p><i class="fas fa-user-tag"></i> <strong>Role:</strong> <span id="userRole"></span></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



</div>

<!-- Footer -->
<footer class="main-footer">
    <strong>&copy; 2024 <a href="https://google.com">Inventory Management System for Perishable Goods</a>.</strong>
    All rights reserved.
</footer>

    <!-- Control Sidebar -->
</div>


<!-- JS includes -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>





<script>


document.addEventListener("DOMContentLoaded", () => {
    const viewButtons = document.querySelectorAll(".view-btn");

    viewButtons.forEach(button => {
        button.addEventListener("click", event => {
            const userName = event.target.getAttribute("data-name");
            const userEmail = event.target.getAttribute("data-email");
            const userRole = event.target.getAttribute("data-role");

            // Populate the modal fields
            document.getElementById("userName").textContent = userName;
            document.getElementById("userEmail").textContent = userEmail;
            document.getElementById("userRole").textContent = userRole;

            // Show the modal
            const viewUserModal = new bootstrap.Modal(document.getElementById("viewUserModal"));
            viewUserModal.show();
        });
    });
});





$(document).ready(function() {
    $('.table').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});




</script>



</body>

</html>