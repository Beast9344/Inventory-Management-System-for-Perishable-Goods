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
    <title>My Products - Consumer Dashboard</title>

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
                <a href="D_Customer_products.php" class="nav-link">Home</a>
            </li>
 
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="" class="brand-link">
            <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
            <span class="brand-text font-weight-light">Consumer Dashboard</span>
        </a>


        <!-- Sidebar -->
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
                <li class="nav-item">
                            <a href="D_Customer_products.php" class="nav-link active">
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
                            <a href="D_My-Order.php" class="nav-link">
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
                                            
                                            

                                                <!-- Add to Cart Button -->
                                        <button class="btn btn-success"
                                            onclick="addToCart({
                                                id: '<?php echo $product['product_id']; ?>',
                                                name: '<?php echo $product['product_name']; ?>',
                                                category: '<?php echo $product['category']; ?>',
                                                price: <?php echo $product['price']; ?>,
                                                stock: <?php echo $product['stock_quantity']; ?>
                                            })">Add to Cart</button>


                                                

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


// Add product to cart
function addToCart(product) {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingProduct = cart.find(item => item.id === product.id);

    if (existingProduct) {
        if (existingProduct.quantity < product.stock) {
            existingProduct.quantity += 1;
        } else {
            alert(`Sorry, only ${product.stock} units of ${product.name} are available.`);
            return;
        }
    } else {
        if (product.stock > 0) {
            cart.push({ ...product, quantity: 1 });
        } else {
            alert(`${product.name} is out of stock.`);
            return;
        }
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    alert(`${product.name} has been added to your cart!`);
}








</script>



</body>

</html>