// Example products for initial data
let products = [
    { id: '#101', name: 'Milk - Full Cream', category: 'Dairy', stock: 250, price: 3.50 },
    { id: '#102', name: 'Cheddar Cheese', category: 'Dairy', stock: 120, price: 5.25 },
    { id: '#103', name: 'Organic Eggs', category: 'Eggs', stock: 450, price: 2.00 },
    { id: '#104', name: 'Fresh Butter', category: 'Dairy', stock: 80, price: 4.75 }
];

// Function to render products dynamically
function renderProducts() {
    const productTableBody = document.querySelector('#productTable tbody');
    productTableBody.innerHTML = '';

    products.forEach((product, index) => {
        const row = `
            <tr>
                <td>${product.id}</td>
                <td>${product.name}</td>
                <td>${product.category}</td>
                <td>${product.stock}</td>
                <td>$${product.price.toFixed(2)}</td>
                <td>
                    <button class="btn btn-primary btn-sm" onclick="viewProduct(${index})">
                        <i class="fas fa-folder"></i> View
                    </button>
                    <button class="btn btn-info btn-sm" onclick="showEditProductModal(${index})">
                        <i class="fas fa-pencil-alt"></i> Edit
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteProduct(${index})">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </td>
            </tr>
        `;
        productTableBody.insertAdjacentHTML('beforeend', row);
    });
}




// Function to view product details
function viewProduct(index) {
    const product = products[index];
    alert(`Product Details:\n\nID: ${product.id}\nName: ${product.name}\nCategory: ${product.category}\nStock: ${product.stock}\nPrice: $${product.price.toFixed(2)}`);
}




// Function to handle adding a new product
function addProduct() {
    const id = `#${products.length + 101}`;
    const name = document.querySelector('#addProductName').value.trim();
    const category = document.querySelector('#addCategory').value.trim();
    const stock = parseInt(document.querySelector('#addStockQuantity').value, 10);
    const price = parseFloat(document.querySelector('#addPrice').value);

    if (name && category && !isNaN(stock) && !isNaN(price)) {
        products.push({ id, name, category, stock, price });
        renderProducts();
        $('#addProductModal').modal('hide'); // Close the modal
        document.querySelector('#addProductForm').reset(); // Reset the form
    } else {
        alert('Please fill in all fields correctly.');
    }
}

// Function to display the edit product modal
function showEditProductModal(index) {
    const product = products[index];
    document.querySelector('#editProductId').value = product.id;
    document.querySelector('#editProductName').value = product.name;
    document.querySelector('#editCategory').value = product.category;
    document.querySelector('#editStockQuantity').value = product.stock;
    document.querySelector('#editPrice').value = product.price;

    // Set the save button's onclick to update the product
    document.querySelector('#saveEditButton').onclick = () => editProduct(index);
    $('#editProductModal').modal('show');
}

// Function to edit a product
function editProduct(index) {
    const id = document.querySelector('#editProductId').value;
    const name = document.querySelector('#editProductName').value.trim();
    const category = document.querySelector('#editCategory').value.trim();
    const stock = parseInt(document.querySelector('#editStockQuantity').value, 10);
    const price = parseFloat(document.querySelector('#editPrice').value);

    if (name && category && !isNaN(stock) && !isNaN(price)) {
        products[index] = { id, name, category, stock, price };
        renderProducts();
        $('#editProductModal').modal('hide'); // Close the modal
    } else {
        alert('Please fill in all fields correctly.');
    }
}

// Function to delete a product
function deleteProduct(index) {
    if (confirm(`Are you sure you want to delete product ${products[index].name}?`)) {
        products.splice(index, 1); // Remove the product from the array
        renderProducts();
    }
}

// Initialize the product list on page load
document.addEventListener('DOMContentLoaded', () => {
    renderProducts();

    // Add product event listener
    document.querySelector('#saveAddButton').addEventListener('click', addProduct);
});
