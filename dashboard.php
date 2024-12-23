<?php
// Start session
session_start();

// Include the database connection file
include 'connect.php';




// Use session data
$email = $_SESSION['email'] ?? null;
$role = $_SESSION['role'] ?? null;





// Initialize variables for error-free rendering
$ordersCount = ['count' => 0];
$usersCount = ['count' => 0];
$employeesCount = ['count' => 0];
$warehousesCount = ['count' => 0];

// Fetch dashboard data
$ordersCount = $conn->query("SELECT COUNT(*) AS count FROM orders")->fetch_assoc();
$usersCount = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc();
$employeesCount = $conn->query("SELECT COUNT(*) AS count FROM employees")->fetch_assoc();
$warehousesCount = $conn->query("SELECT COUNT(*) AS count FROM warehouses")->fetch_assoc();




// Initialize variables for error-free rendering
$alertsCount = ['count' => 0];
$orderItemsCount = ['count' => 0];
$productsCount = ['count' => 0];
$storageCount = ['count' => 0];

// Fetch dashboard data
$alertsCount = $conn->query("SELECT COUNT(*) AS count FROM alerts")->fetch_assoc();
$orderItemsCount = $conn->query("SELECT COUNT(*) AS count FROM order_items")->fetch_assoc();
$productsCount = $conn->query("SELECT COUNT(*) AS count FROM products")->fetch_assoc();
$storageCount = $conn->query("SELECT COUNT(*) AS count FROM storage")->fetch_assoc();










// Fetch the most recent order (live)
$lastOrderQuery = $conn->query("
    SELECT order_id, customer_name, status, order_date, total_amount 
    FROM orders 
    ORDER BY order_date DESC, order_id DESC 
    LIMIT 1
");
$lastOrder = $lastOrderQuery ? $lastOrderQuery->fetch_assoc() : null;




// Fetch the most recent alert (live)
$lastAlertQuery = $conn->query("
    SELECT alert_id, alert_type, description, alert_date, status
    FROM alerts
    ORDER BY alert_date DESC, alert_id DESC
    LIMIT 1
");
$lastAlert = $lastAlertQuery ? $lastAlertQuery->fetch_assoc() : null;



// Fetch the most recent storage (live)
$lastStorageQuery = $conn->query("
    SELECT storage_id, storage_name, capacity, used_capacity
    FROM storage
    ORDER BY storage_id DESC
    LIMIT 1
");
$lastStorage = $lastStorageQuery ? $lastStorageQuery->fetch_assoc() : null;


// Fetch the most recent product (live)
$lastProductQuery = $conn->query("
    SELECT product_id, product_name, category, stock_quantity, price
    FROM products
    ORDER BY product_id DESC
    LIMIT 1
");
$lastProduct = $lastProductQuery ? $lastProductQuery->fetch_assoc() : null;




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
    LIMIT 1
";
$lastGroupedOrderQuery = $conn->query($query);
$lastGroupedOrder = $lastGroupedOrderQuery ? $lastGroupedOrderQuery->fetch_assoc() : null;


// Fetch the warehouse with the highest capacity
$query = "
    SELECT 
        warehouse_id, 
        warehouse_name, 
        location, 
        capacity,
        stock_level 
    FROM warehouses 
    ORDER BY capacity DESC 
    LIMIT 1
";
$result = $conn->query($query);

// Fetch the warehouse with the highest capacity
$highestCapacityWarehouse = $result->num_rows > 0 ? $result->fetch_assoc() : null;





// Fetch the employee with the highest years of service
$topEmployeeQuery = $conn->query("
    SELECT 
        employee_id, 
        name, 
        department, 
        job_title, 
        location, 
        years_of_service 
    FROM employees 
    ORDER BY years_of_service DESC 
    LIMIT 1
");
$topEmployee = $topEmployeeQuery ? $topEmployeeQuery->fetch_assoc() : null;





// Fetch the order with the highest total paid
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
    ORDER BY total DESC
    LIMIT 1
";
$result = $conn->query($query);

// Fetch the highest total order
$highestOrder = $result->num_rows > 0 ? $result->fetch_assoc() : null;





// Fetch all sales grouped by month names
$monthlySales = $conn->query("
    SELECT MONTHNAME(order_date) AS month_name, 
           SUM(total_amount) AS sales 
    FROM orders 
    GROUP BY MONTH(order_date)
    ORDER BY MONTH(order_date)
")->fetch_all(MYSQLI_ASSOC);



// Fetch all sales grouped by day names
$dailySales = $conn->query("
    SELECT DAYNAME(order_date) AS day_name, 
           SUM(total_amount) AS sales 
    FROM orders 
    GROUP BY DAYOFWEEK(order_date)
    ORDER BY DAYOFWEEK(order_date)
")->fetch_all(MYSQLI_ASSOC);





// Fetch weekly sales data (grouped by week)
$weeklySales = $conn->query("
    SELECT CONCAT('Week ', WEEK(order_date)) AS week_name, 
           SUM(total_amount) AS total_amount 
    FROM orders 
    GROUP BY WEEK(order_date)
    ORDER BY WEEK(order_date)
")->fetch_all(MYSQLI_ASSOC);

// Fetch monthly sales data (grouped by month)
$monthlySalesTotal = $conn->query("
    SELECT MONTHNAME(order_date) AS month_name, 
           SUM(total_amount) AS total_amount 
    FROM orders 
    GROUP BY MONTH(order_date)
    ORDER BY MONTH(order_date)
")->fetch_all(MYSQLI_ASSOC);











?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory Management System</title>

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
    <!-- Chart.js (for generating charts) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="dashboard.css">

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
    <!-- /.navbar -->

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
                            <a href="dashboard.php" class="nav-link active">
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
        </aside>

<!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">




                     <!-- Dashboard Section -->
                    <div class="row">

                        <!-- Orders Count -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h3 style="font-weight: bold; font-size: 2rem;"><?= htmlspecialchars($ordersCount['count']); ?></h3>
                                    <p style="font-weight: bold; font-size: 1.2rem;">Orders</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-bag"></i>
                                </div>
                                <a href="orders.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Users Count -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-indigo">
                                <div class="inner">
                                    <h3 style="font-weight: bold; font-size: 2rem;"><?= htmlspecialchars($usersCount['count']); ?></h3>
                                    <p style="font-weight: bold; font-size: 1.2rem;">Users</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <a href="users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Employees Count -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-dark">
                                <div class="inner">
                                    <h3 style="font-weight: bold; font-size: 2rem;"><?= htmlspecialchars($employeesCount['count']); ?></h3>
                                    <p style="font-weight: bold; font-size: 1.2rem;">Employees</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-user-tie"></i>
                                </div>
                                <a href="employees.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Warehouses Count -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-orange">
                                <div class="inner">
                                    <h3 style="font-weight: bold; font-size: 2rem;"><?= htmlspecialchars($warehousesCount['count']); ?></h3>
                                    <p style="font-weight: bold; font-size: 1.2rem;">Warehouses</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-warehouse"></i>
                                </div>
                                <a href="warehouses.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>





                                
                    <div class="row">
                        <!-- Alerts Count -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3 style="font-weight: bold; font-size: 2rem;"><?= htmlspecialchars($alertsCount['count']); ?></h3>
                                    <p style="font-weight: bold; font-size: 1.2rem;">Alerts</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <a href="alerts.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Order Items Count -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3 style="font-weight: bold; font-size: 2rem;"><?= htmlspecialchars($orderItemsCount['count']); ?></h3>
                                    <p style="font-weight: bold; font-size: 1.2rem;">Order Items</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <a href="Customer_Order.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Products Count -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3 style="font-weight: bold; font-size: 2rem;"><?= htmlspecialchars($productsCount['count']); ?></h3>
                                    <p style="font-weight: bold; font-size: 1.2rem;">Products</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <a href="products.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <!-- Storage Count -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box bg-danger">
                                <div class="inner">
                                    <h3 style="font-weight: bold; font-size: 2rem;"><?= htmlspecialchars($storageCount['count']); ?></h3>
                                    <p style="font-weight: bold; font-size: 1.2rem;">Storage</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-warehouse"></i>
                                </div>
                                <a href="storage.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>





                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h3 class="chart-title">Daily Sales</h3>
                                <canvas id="dailySalesChart"></canvas>
                                <h3 class="chart-title">Weekly Sales Summary</h3>
                                <canvas id="weeklySalesPieChart"></canvas>
                            </div>
                            <div class="col-md-6">
                                <h3 class="chart-title">Monthly Sales</h3>
                                <canvas id="monthlySalesChart"></canvas>
                                <h3 class="chart-title">Monthly Sales Summary</h3>
                                <canvas id="monthlySalesPieChart"></canvas>
                            </div>
                        </div>





<!-- Container for the Card Sections -->
<div class="row">

<!-- Enhanced Last Order Section -->
<div class="col-md-6">
    <div class="card">
        <h3>Latest Order</h3>
        <?php if ($lastOrder): ?>
            <p><strong>Order ID:</strong> <?= htmlspecialchars($lastOrder['order_id']) ?></p>
            <p><strong>Customer Name:</strong> <?= htmlspecialchars($lastOrder['customer_name']) ?></p>
            <p><strong>Status:</strong> 
                <?php if ($lastOrder['status'] === 'Pending'): ?>
                    <span style="color: orange;"><?= htmlspecialchars($lastOrder['status']) ?></span>
                <?php elseif ($lastOrder['status'] === 'Completed'): ?>
                    <span style="color: green;"><?= htmlspecialchars($lastOrder['status']) ?></span>
                <?php elseif ($lastOrder['status'] === 'Cancelled'): ?>
                    <span style="color: red;"><?= htmlspecialchars($lastOrder['status']) ?></span>
                <?php else: ?>
                    <?= htmlspecialchars($lastOrder['status']) ?>
                <?php endif; ?>
            </p>
            <p><strong>Date:</strong> <?= htmlspecialchars(date('F j, Y', strtotime($lastOrder['order_date']))) ?></p>
            <p><strong>Total Amount:</strong> $<?= htmlspecialchars(number_format($lastOrder['total_amount'], 2)) ?></p>
            <p><strong>Order Summary:</strong> 
                <?= $lastOrder['status'] === 'Completed' 
                    ? 'This order has been successfully fulfilled.' 
                    : 'Pending actions for this order.'; ?>
            </p>
        <?php else: ?>
            <p>No recent orders found.</p>
        <?php endif; ?>
    </div>
</div>

    <!-- Enhanced Most Recent Product Section -->
    <div class="col-md-6">
        <div class="card">
            <h3>Latest Product</h3>
            <?php if ($lastProduct): ?>
                <p><strong>Product ID:</strong> <?= $lastProduct['product_id'] ?></p>
                <p><strong>Name:</strong> <?= $lastProduct['product_name'] ?></p>
                <p><strong>Category:</strong> <?= $lastProduct['category'] ?></p>
                <p><strong>Stock Quantity:</strong> <?= $lastProduct['stock_quantity'] ?></p>
                <p><strong>Price:</strong> $<?= number_format($lastProduct['price'], 2) ?></p>
                <p><strong>Total Stock Value:</strong> $<?= number_format($lastProduct['stock_quantity'] * $lastProduct['price'], 2) ?></p>
            <?php else: ?>
                <p>No product details found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Another Row for the Last Alert and Last Storage Sections -->
<div class="row">
    <!-- Enhanced Last Alert Section -->
    <div class="col-md-6">
        <div class="card">
            <h3>Latest Alert</h3>
            <?php if ($lastAlert): ?>
                <p><strong>Alert ID:</strong> <?= $lastAlert['alert_id'] ?></p>
                <p><strong>Type:</strong> <?= $lastAlert['alert_type'] ?></p>
                <p><strong>Description:</strong> <?= $lastAlert['description'] ?></p>
                <p><strong>Date:</strong> <?= date('F j, Y', strtotime($lastAlert['alert_date'])) ?></p>
                <p><strong>Status:</strong> 
                    <?php if ($lastAlert['status'] === 'Active'): ?>
                        <span style="color: orange;"><?= $lastAlert['status'] ?> (Action Required)</span>
                    <?php elseif ($lastAlert['status'] === 'Resolved'): ?>
                        <span style="color: green;"><?= $lastAlert['status'] ?></span>
                    <?php elseif ($lastAlert['status'] === 'Closed'): ?>
                        <span style="color: gray;"><?= $lastAlert['status'] ?></span>
                    <?php else: ?>
                        <?= $lastAlert['status'] ?>
                    <?php endif; ?>
                </p>
                <p><strong>Alert Summary:</strong> 
                    <?= $lastAlert['status'] === 'Active' ? 'This alert needs immediate attention!' : 'No further action needed.'; ?>
                </p>
            <?php else: ?>
                <p>No recent alerts found.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Enhanced Most Recent Storage Section -->
    <div class="col-md-6">
        <div class="card">
            <h3>Latest Storage</h3>
            <?php if ($lastStorage): ?>
                <p><strong>Storage ID:</strong> <?= $lastStorage['storage_id'] ?></p>
                <p><strong>Name:</strong> <?= $lastStorage['storage_name'] ?></p>
                <p><strong>Capacity:</strong> <?= $lastStorage['capacity'] ?> units</p>
                <p><strong>Used Capacity:</strong> <?= $lastStorage['used_capacity'] ?> units</p>
                <p><strong>Usage Percentage:</strong> <?= round(($lastStorage['used_capacity'] / $lastStorage['capacity']) * 100, 2) ?>%</p>
            <?php else: ?>
                <p>No storage details found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>



<!-- Another Row for the Customer Order and  Last Employee  Sections -->
<div class="row">

<!-- Enhanced Customer Order Items Section -->
<div class="col-md-6">
    <div class="card">
        <h3>Latest Customer Order</h3>
        <?php if ($lastGroupedOrder): ?>
            <p><strong>Order ID:</strong> <?= htmlspecialchars($lastGroupedOrder['order_id']) ?></p>
            <p><strong>Products:</strong> <?= htmlspecialchars($lastGroupedOrder['product_names']) ?></p>
            <p><strong>Subtotal:</strong> $<?= htmlspecialchars(number_format($lastGroupedOrder['subtotal'], 2)) ?></p>
            <p><strong>Total:</strong> $<?= htmlspecialchars(number_format($lastGroupedOrder['total'], 2)) ?></p>
            <p><strong>Payment Method:</strong> <?= htmlspecialchars($lastGroupedOrder['payment_method']) ?></p>
            <p><strong>Order Date:</strong> <?= htmlspecialchars(date('F j, Y', strtotime($lastGroupedOrder['order_date']))) ?></p>
            <p><strong>Order Summary:</strong> 
                <?= $lastGroupedOrder['payment_method'] === 'Credit Card' 
                    ? 'This order was paid via Credit Card.' 
                    : 'Payment method details are provided.'; ?>
            </p>
        <?php else: ?>
            <p>No grouped order items found.</p>
        <?php endif; ?>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
            <h3>Warehouse with the Highest Capacity</h3>
        <div class="card-body">
            <?php if ($highestCapacityWarehouse): ?>
                <p><strong>Warehouse ID:</strong> <?= htmlspecialchars($highestCapacityWarehouse['warehouse_id']); ?></p>
                <p><strong>Name:</strong> <?= htmlspecialchars($highestCapacityWarehouse['warehouse_name']); ?></p>
                <p><strong>Location:</strong> <?= htmlspecialchars($highestCapacityWarehouse['location']); ?></p>
                <p><strong>Capacity:</strong> <?= number_format($highestCapacityWarehouse['capacity']); ?> units</p>
                <p><strong>Stock Level:</strong> <?= number_format($highestCapacityWarehouse['stock_level']); ?> units</p>
                <p>
                    <strong>Utilization Rate:</strong> 
                    <?= round(($highestCapacityWarehouse['stock_level'] / $highestCapacityWarehouse['capacity']) * 100, 2); ?>%
                </p>
            <?php else: ?>
                <p>No warehouse data found.</p>
            <?php endif; ?>
        </div>
    </div>
</div>






</div>

<!-- Another Row for the Highest Years of Service Highest Total Paid  Sections -->
<div class="row">

<!-- Employee with Highest Years of Service Section -->
<div class="col-md-6">
    <div class="card">
        <h3>Employee with the Highest Years of Service</h3>
        <?php if ($topEmployee): ?>
            <p><strong>Employee ID:</strong> <?= htmlspecialchars($topEmployee['employee_id']) ?></p>
            <p><strong>Name:</strong> <?= htmlspecialchars($topEmployee['name']) ?></p>
            <p><strong>Department:</strong> <?= htmlspecialchars($topEmployee['department']) ?></p>
            <p><strong>Job Title:</strong> <?= htmlspecialchars($topEmployee['job_title']) ?></p>
            <p><strong>Location:</strong> <?= htmlspecialchars($topEmployee['location']) ?></p>
            <p><strong>Years of Service:</strong> <?= htmlspecialchars($topEmployee['years_of_service']) ?> years</p>
            <p><strong>Employee Summary:</strong> 
                <?= $topEmployee['years_of_service'] > 10 
                    ? 'This employee has over 10 years of dedicated service and is a cornerstone of the team.' 
                    : 'This employee has contributed significantly to the company.'; ?>
            </p>
        <?php else: ?>
            <p>No employee data found.</p>
        <?php endif; ?>
    </div>
</div>




<div class="col-md-6">
    <div class="card">
        <h3>Order with the Highest Total Paid</h3>
        <?php if ($highestOrder): ?>
            <p><strong>Order ID:</strong> <?= htmlspecialchars($highestOrder['order_id']); ?></p>
            <p><strong>Products:</strong> <?= htmlspecialchars($highestOrder['product_names']); ?></p>
            <p><strong>Subtotal:</strong> $<?= number_format($highestOrder['subtotal'], 2); ?></p>
            <p><strong>Total Paid:</strong> $<?= number_format($highestOrder['total'], 2); ?></p>
            <p><strong>Payment Method:</strong> <?= htmlspecialchars($highestOrder['payment_method']); ?></p>
            <p><strong>Order Date:</strong> <?= htmlspecialchars($highestOrder['order_date']); ?></p>
        <?php else: ?>
            <p>No order data found.</p>
        <?php endif; ?>
    </div>
</div>


</div>







        <!-- Footer -->
        <footer class="main-footer">
            <strong>&copy; 2024 <a href="https://google.com">Inventory Management System for Perishable Goods</a>.</strong>
            All rights reserved.
        </footer>
        </div>






<!-- JS includes -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>









<script>




        // Daily Sales Chart
        const dailySalesData = <?= json_encode($dailySales); ?>;
        const dailyCtx = document.getElementById("dailySalesChart").getContext("2d");
        if (dailySalesData.length > 0) {
            new Chart(dailyCtx, {
                type: "bar",
                data: {
                    labels: dailySalesData.map(s => s.day_name),
                    datasets: [{
                        label: "Daily Sales",
                        data: dailySalesData.map(s => s.sales),
                        backgroundColor: "rgba(54, 162, 235, 0.5)",
                        borderColor: "rgba(54, 162, 235, 1)",
                    }]
                }
            });
        }



        // Monthly Sales Chart
        const monthlySalesData = <?= json_encode($monthlySales); ?>;
        const monthlyCtx = document.getElementById("monthlySalesChart").getContext("2d");
        if (monthlySalesData.length > 0) {
            new Chart(monthlyCtx, {
                type: "line",
                data: {
                    labels: monthlySalesData.map(s => s.month_name),
                    datasets: [{
                        label: "Monthly Sales",
                        data: monthlySalesData.map(s => s.sales),
                        borderColor: "rgba(255, 99, 132, 1)",
                        backgroundColor: "rgba(255, 99, 132, 0.2)"
                    }]
                }
            });
        }




        // Weekly Sales Pie Chart
        const weeklySalesData = <?= json_encode($weeklySales); ?>;
        const weeklyPieCtx = document.getElementById("weeklySalesPieChart").getContext("2d");
        if (weeklySalesData.length > 0) {
            new Chart(weeklyPieCtx, {
                type: "pie",
                data: {
                    labels: weeklySalesData.map(w => w.week_name),
                    datasets: [{
                        label: "Weekly Sales",
                        data: weeklySalesData.map(w => w.total_amount),
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.5)",
                            "rgba(54, 162, 235, 0.5)",
                            "rgba(75, 192, 192, 0.5)",
                            "rgba(255, 206, 86, 0.5)",
                            "rgba(153, 102, 255, 0.5)",
                            "rgba(255, 159, 64, 0.5)"
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba(255, 159, 64, 1)"
                        ],
                        borderWidth: 1
                    }]
                }
            });
        }




        // Monthly Sales Pie Chart
        const monthlySalesPieData = <?= json_encode($monthlySalesTotal); ?>;
        const monthlyPieCtx = document.getElementById("monthlySalesPieChart").getContext("2d");
        if (monthlySalesPieData.length > 0) {
            new Chart(monthlyPieCtx, {
                type: "pie",
                data: {
                    labels: monthlySalesPieData.map(m => m.month_name),
                    datasets: [{
                        label: "Monthly Sales",
                        data: monthlySalesPieData.map(m => m.total_amount),
                        backgroundColor: [
                            "rgba(255, 99, 132, 0.5)",
                            "rgba(54, 162, 235, 0.5)",
                            "rgba(75, 192, 192, 0.5)",
                            "rgba(255, 206, 86, 0.5)",
                            "rgba(153, 102, 255, 0.5)",
                            "rgba(255, 159, 64, 0.5)"
                        ],
                        borderColor: [
                            "rgba(255, 99, 132, 1)",
                            "rgba(54, 162, 235, 1)",
                            "rgba(75, 192, 192, 1)",
                            "rgba(255, 206, 86, 1)",
                            "rgba(153, 102, 255, 1)",
                            "rgba(255, 159, 64, 1)"
                        ],
                        borderWidth: 1
                    }]
                }
            });
        }





    </script>
</body>

</html>
