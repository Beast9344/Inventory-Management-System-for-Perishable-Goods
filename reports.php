<?php
include('connect.php');

// Handle Add Report request
if (isset($_POST['addReport'])) {
    $report_name = $_POST['reportName'];
    $details = $_POST['reportDetails'];

    $insertQuery = "INSERT INTO reports (report_name, details) VALUES ('$report_name', '$details')";
    if (mysqli_query($conn, $insertQuery)) {
        $message = "Report created successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Fetch all reports
$query = "SELECT * FROM reports";
$result = mysqli_query($conn, $query);

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reports - Inventory Management System</title>

    <!-- Include external CSS and JS libraries -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
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

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Inventory System</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item"><a href="dashboard.php" class="nav-link"><i class="nav-icon fas fa-tachometer-alt"></i> <p>Dashboard</p></a></li>
                        <li class="nav-item"><a href="inventory.php" class="nav-link"><i class="nav-icon fas fa-cogs"></i> <p>Inventory</p></a></li>
                        <li class="nav-item"><a href="employees.php" class="nav-link"><i class="nav-icon fas fa-users"></i> <p>Employees</p></a></li>
                        <li class="nav-item active"><a href="reports.php" class="nav-link"><i class="nav-icon fas fa-chart-line"></i> <p>Reports</p></a></li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="m-0 text-dark">Reports</h1>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addReportModal"><i class="fas fa-plus"></i> Add Report</button>
                </div>

                <?php if (isset($message)) { ?>
                    <div class="alert alert-info mt-3"><?php echo $message; ?></div>
                <?php } ?>

                <!-- Report Table -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Report List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Report Name</th>
                                    <th>Report Date</th>
                                    <th>Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['report_name'] ?></td>
                                        <td><?= $row['report_date'] ?></td>
                                        <td><?= $row['details'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">Anything you want</div>
            <strong>&copy; 2024 <a href="#">Inventory Management System</a>.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Add Report Modal -->
    <div class="modal fade" id="addReportModal" tabindex="-1" aria-labelledby="addReportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addReportModalLabel">Add New Report</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="reports.php">
                        <div class="form-group">
                            <label for="reportName">Report Name</label>
                            <input type="text" class="form-control" name="reportName" required>
                        </div>
                        <div class="form-group">
                            <label for="reportDetails">Details</label>
                            <textarea class="form-control" name="reportDetails"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addReport">Save Report</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
