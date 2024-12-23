<?php
include('connect.php');

// Fetch all inventory items
$query = "SELECT * FROM inventory";
$result = mysqli_query($conn, $query);

// Handle Add Inventory request
if (isset($_POST['addInventory'])) {
    $name = $_POST['itemName'];
    $quantity = $_POST['itemQuantity'];
    $price = $_POST['itemPrice'];
    $description = $_POST['itemDescription'];

    $insertQuery = "INSERT INTO inventory (name, quantity, price, description) 
                    VALUES ('$name', '$quantity', '$price', '$description')";
    if (mysqli_query($conn, $insertQuery)) {
        $message = "Item added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Handle Edit Inventory request
if (isset($_POST['editInventory'])) {
    $id = $_POST['itemId'];
    $name = $_POST['itemName'];
    $quantity = $_POST['itemQuantity'];
    $price = $_POST['itemPrice'];
    $description = $_POST['itemDescription'];

    $updateQuery = "UPDATE inventory SET name='$name', quantity='$quantity', price='$price', description='$description' WHERE id='$id'";
    if (mysqli_query($conn, $updateQuery)) {
        $message = "Item updated successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Handle Delete Inventory request
if (isset($_GET['deleteId'])) {
    $deleteId = $_GET['deleteId'];
    $deleteQuery = "DELETE FROM inventory WHERE id='$deleteId'";
    if (mysqli_query($conn, $deleteQuery)) {
        $message = "Item deleted successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory - Inventory Management System</title>

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
                        <li class="nav-item active"><a href="inventory.php" class="nav-link"><i class="nav-icon fas fa-cogs"></i> <p>Inventory</p></a></li>
                        <li class="nav-item"><a href="employees.php" class="nav-link"><i class="nav-icon fas fa-users"></i> <p>Employees</p></a></li>
                        <li class="nav-item"><a href="reports.php" class="nav-link"><i class="nav-icon fas fa-chart-line"></i> <p>Reports</p></a></li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="m-0 text-dark">Inventory</h1>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addItemModal"><i class="fas fa-plus"></i> Add Item</button>
                </div>

                <?php if (isset($message)) { ?>
                    <div class="alert alert-info mt-3"><?php echo $message; ?></div>
                <?php } ?>

                <!-- Inventory Table -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Inventory List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                    <tr>
                                        <td><?= $row['id'] ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['quantity'] ?></td>
                                        <td><?= $row['price'] ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editItemModal" onclick="editItem(<?= $row['id'] ?>, '<?= $row['name'] ?>', <?= $row['quantity'] ?>, <?= $row['price'] ?>, '<?= $row['description'] ?>')">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteItemModal" onclick="setDeleteId(<?= $row['id'] ?>)">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </td>
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

    <!-- Add Item Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="inventory.php">
                        <div class="form-group">
                            <label for="itemName">Name</label>
                            <input type="text" class="form-control" name="itemName" required>
                        </div>
                        <div class="form-group">
                            <label for="itemQuantity">Quantity</label>
                            <input type="number" class="form-control" name="itemQuantity" required>
                        </div>
                        <div class="form-group">
                            <label for="itemPrice">Price</label>
                            <input type="number" class="form-control" name="itemPrice" required>
                        </div>
                        <div class="form-group">
                            <label for="itemDescription">Description</label>
                            <textarea class="form-control" name="itemDescription"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="addInventory">Save Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Item Modal -->
    <div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editItemModalLabel">Edit Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="inventory.php">
                        <input type="hidden" name="itemId" id="editItemId">
                        <div class="form-group">
                            <label for="editItemName">Name</label>
                            <input type="text" class="form-control" name="itemName" id="editItemName" required>
                        </div>
                        <div class="form-group">
                            <label for="editItemQuantity">Quantity</label>
                            <input type="number" class="form-control" name="itemQuantity" id="editItemQuantity" required>
                        </div>
                        <div class="form-group">
                            <label for="editItemPrice">Price</label>
                            <input type="number" class="form-control" name="itemPrice" id="editItemPrice" required>
                        </div>
                        <div class="form-group">
                            <label for="editItemDescription">Description</label>
                            <textarea class="form-control" name="itemDescription" id="editItemDescription"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="editInventory">Update Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Item Modal -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" aria-labelledby="deleteItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteItemModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger" id="confirmDeleteButton">Delete Item</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function setDeleteId(id) {
            const deleteButton = document.getElementById('confirmDeleteButton');
            deleteButton.setAttribute('href', `inventory.php?deleteId=${id}`);
        }

        function editItem(id, name, quantity, price, description) {
            document.getElementById('editItemId').value = id;
            document.getElementById('editItemName').value = name;
            document.getElementById('editItemQuantity').value = quantity;
            document.getElementById('editItemPrice').value = price;
            document.getElementById('editItemDescription').value = description;
        }
    </script>
</body>
</html>
