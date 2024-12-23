<?php
// Include database connection file
include('connect.php');

// Fetch products from the database
$query = "SELECT * FROM products";
$result = $conn->query($query);

// Initialize an array to store the fetched products
$products = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    // If no products found, return an empty array
    $products = [];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products - Inventory Management System</title>

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


        
.search-container {
    background: linear-gradient(to right, #6a11cb, #2575fc);
    color: #fff;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    margin-bottom: 30px;
}

.search-container h3 {
    font-size: 1.6rem;
    margin-bottom: 15px;
    font-weight: 500;
}

.search-container input {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 2px solid #fff;
    border-radius: 8px;
    margin-bottom: 15px;
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
}

.search-container input:focus {
    border-color: #2575fc;
    outline: none;
}

.search-container button {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    background-color: #2575fc;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-container button:hover {
    background-color: #6a11cb;
}

.category-container {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 30px;
}

.category-container button {
    width: 160px;
    padding: 12px;
    font-size: 1rem;
    border-radius: 8px;
    border: 2px solid #2575fc;
    background-color: transparent;
    color: #2575fc;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.category-container button:hover {
    background-color: #2575fc;
    color: #fff;
}

.category-container .btn-outline-primary:hover {
    background-color: #6a11cb;
    color: #fff;
}

.category-container .btn-outline-success:hover {
    background-color: #28a745;
    color: #fff;
}

.category-container .btn-outline-danger:hover {
    background-color: #dc3545;
    color: #fff;
}

.category-container .btn-outline-warning:hover {
    background-color: #ffc107;
    color: #fff;
}

.category-container .btn-outline-dark:hover {
    background-color: #343a40;
    color: #fff;
}

.category-container .btn-outline-secondary:hover {
    background-color: #6c757d;
    color: #fff;
}

#show-all-products-btn {
    background-color: #6c757d;
    color: #fff;
    border: 2px solid #6c757d;
    padding: 12px;
    font-size: 1rem;
    border-radius: 8px;
    width: 100%;
    cursor: pointer;
}

#show-all-products-btn:hover {
    background-color: #495057;
    border-color: #495057;
}

@media (max-width: 768px) {
    .category-container {
        flex-direction: column;
    }

    .category-container button {
        width: 100%;
    }
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
                        <a href="products.php" class="nav-link active">
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
        <!-- /.sidebar -->
    </aside>





<!-- Content Wrapper -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Products Page</h1>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">





                <div class="text-left mb-4">
                    <h1>Product Directory</h1>
                    <p>Search and explore product details</p>
                </div>

                <!-- Search Container -->
                <div class="card search-container p-3 mb-3">
                    <h3>Search Product</h3>
                    <input type="text" id="product-id" class="form-control mb-2" placeholder="Enter Product ID">
                    <button onclick="searchProduct()" class="btn btn-light">Search</button>
                </div>

                <!-- Filters -->
                <h3 class="mb-3">Browse by Category</h3>
                <div class="category-container d-flex justify-content-start mb-4">
                    <button class="btn btn-outline-primary me-2" onclick="filterByCategory('Electronics')">Electronics</button>
                    <button class="btn btn-outline-success me-2" onclick="filterByCategory('vegatable')">Vegatable</button>
                    <button class="btn btn-outline-danger me-2" onclick="filterByCategory('fruits')">Fruits</button>
                    <button class="btn btn-outline-warning me-2" onclick="filterByCategory('Accessories')">Accessories</button>
                    <button class="btn btn-outline-dark me-2" onclick="filterByCategory('Office Supplies')">Office Supplies</button>
                    <button class="btn btn-outline-secondary" id="show-all-products-btn">All Products</button>
                </div>



            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Inventory</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addProductModal">
                            <i class="fas fa-plus"></i> Add Product
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped projects" id="productTable">
                        <thead>
                            <tr>
                                <th style="width: 10%">Product ID</th>
                                <th style="width: 20%">Product Name</th>
                                <th style="width: 20%">Category</th>
                                <th style="width: 15%">Stock Quantity</th>
                                <th style="width: 15%">Price ($)</th>
                                <th style="width: 20%">Actions</th>
                            </tr>
                        </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($product['product_id']); ?></td>
                                        <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                        <td><?php echo htmlspecialchars($product['category']); ?></td>
                                        <td><?php echo htmlspecialchars($product['stock_quantity']); ?></td>
                                        <td>$<?php echo number_format($product['price'], 2); ?></td>
                                        <td>

                                        <!-- View Button -->
                                        <button class="btn btn-info" 
                                            data-toggle="modal" 
                                            data-target="#viewProductModal" 
                                            data-id="<?php echo $product['product_id']; ?>"
                                            data-name="<?php echo $product['product_name']; ?>"
                                            data-category="<?php echo $product['category']; ?>"
                                            data-stock="<?php echo $product['stock_quantity']; ?>"
                                            data-price="<?php echo $product['price']; ?>">View
                                            </button>                                

                                        <!-- Edit Button -->
                                            <button class="btn btn-warning" 
                                                data-toggle="modal" 
                                                data-target="#editProductModal" 
                                                data-id="<?php echo $product['product_id']; ?>"
                                                data-name="<?php echo $product['product_name']; ?>"
                                                data-category="<?php echo $product['category']; ?>"
                                                data-stock="<?php echo $product['stock_quantity']; ?>"
                                                data-price="<?php echo $product['price']; ?>">Edit
                                            </button>

                                         <!-- Delete Button -->                                      
                                         <button class="btn btn-danger" 
                                                data-toggle="modal" 
                                                data-target="#deleteProductModal" 
                                                data-id="<?php echo $product['product_id']; ?>">Delete
                                            </button>
                                            

                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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

    <!-- Control Sidebar -->
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add-product.php" method="POST">
                    <div class="form-group">
                        <label for="productId">Product ID</label>
                        <input type="text" class="form-control" name="product_id" id="productId" required>
                    </div>
                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="productName" required>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <input type="text" class="form-control" name="category" id="category" required>
                    </div>
                    <div class="form-group">
                        <label for="stockQuantity">Stock Quantity</label>
                        <input type="number" class="form-control" name="stock_quantity" id="stockQuantity" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" name="price" id="price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product?</p>
                <input type="hidden" id="productIdToDelete">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteButton" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editProductForm">
                    <input type="hidden" id="editProductId" name="product_id">
                    <div class="form-group">
                        <label for="editProductName">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="editCategory">Category</label>
                        <input type="text" class="form-control" id="editCategory" name="category" required>
                    </div>
                    <div class="form-group">
                        <label for="editStock">Stock Quantity</label>
                        <input type="number" class="form-control" id="editStock" name="stock_quantity" required>
                    </div>
                    <div class="form-group">
                        <label for="editPrice">Price</label>
                        <input type="number" step="0.01" class="form-control" id="editPrice" name="price" required>
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


<!-- View Product Modal -->

<div class="modal fade" id="viewProductModal" tabindex="-1" role="dialog" aria-labelledby="viewProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductModalLabel">Product Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Product Name:</strong> <span id="viewProductName"></span></p>
                <p><strong>Category:</strong> <span id="viewProductCategory"></span></p>
                <p><strong>Stock:</strong> <span id="viewProductStock"></span></p>
                <p><strong>Price:</strong> $<span id="viewProductPrice"></span></p>
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





// Search Product by ID
function searchProduct() {
    var searchId = $('#product-id').val().trim();

    if (searchId === '') {
        alert('Please enter a valid Product ID.');
        return;
    }

    // Iterate through the table rows and find the matching ID
    $('#productTable tbody tr').each(function () {
        var row = $(this);
        var productId = row.find('td:first').text().trim();

        if (productId === searchId) {
            row.show();
        } else {
            row.hide();
        }
    });
}

// Filter by Category
function filterByCategory(category) {
    $('#productTable tbody tr').each(function () {
        var row = $(this);
        var productCategory = row.find('td:nth-child(3)').text().trim();

        if (productCategory === category) {
            row.show();
        } else {
            row.hide();
        }
    });
}

// Show All Products
$('#show-all-products-btn').click(function () {
    $('#productTable tbody tr').show();
});










    // View Product Modal

$('#viewProductModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var name = button.data('name');
    var category = button.data('category');
    var stock = button.data('stock');
    var price = button.data('price');

    var modal = $(this);
    modal.find('#viewProductName').text(name);
    modal.find('#viewProductCategory').text(category);
    modal.find('#viewProductStock').text(stock);
    modal.find('#viewProductPrice').text(price);
});



    // Delete Product Modal

    // When the modal is about to be shown
    $('#deleteProductModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var productId = button.data('id'); // Extract the product_id from data-* attribute
        var modal = $(this);

        // Set the hidden input value with the product_id
        modal.find('#productIdToDelete').val(productId);
    });

    // When the delete button is clicked in the modal
    $('#confirmDeleteButton').click(function () {
        var productId = $('#productIdToDelete').val(); // Get the product_id

        // Send an AJAX request to delete the product
        $.ajax({
            type: "POST",
            url: "delete-product.php", // PHP script to handle deletion
            data: { product_id: productId },
            success: function (response) {
                // Close the modal
                $('#deleteProductModal').modal('hide');
                
                // Reload the page or update the UI as needed
                alert(response); // Display the response
                location.reload(); // Reload the page to reflect changes
            },
            error: function () {
                alert('Error deleting product.');
            }
        });
    });

 // When the edit modal is about to be shown
 $('#editProductModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var productId = button.data('id'); // Extract product data from data-* attributes
        var productName = button.data('name');
        var category = button.data('category');
        var stock = button.data('stock');
        var price = button.data('price');

        // Set the values in the modal fields
        $('#editProductId').val(productId);
        $('#editProductName').val(productName);
        $('#editCategory').val(category);
        $('#editStock').val(stock);
        $('#editPrice').val(price);
    });

    // When the save button is clicked in the modal
    $('#saveEditButton').click(function () {
        // Serialize the form data
        var formData = $('#editProductForm').serialize();

        // Send an AJAX request to update the product
        $.ajax({
            type: "POST",
            url: "update-product.php", // PHP script to handle the update
            data: formData,
            success: function (response) {
                // Close the modal
                $('#editProductModal').modal('hide');

                // Reload the page or update the UI as needed
                alert(response); // Display the response
                location.reload(); // Reload the page to reflect changes
            },
            error: function () {
                alert('Error updating product.');
            }
        });
    });

</script>



</body>

</html>