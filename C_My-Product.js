document.addEventListener('DOMContentLoaded', () => {
    const products = [
        { id: 1, name: "Laptop", price: 700, category: "Electronics", image: "img/laptop.jpg" },
        { id: 2, name: "Smartphone", price: 500, category: "Electronics", image: "img/phone.jpg" },
        { id: 3, name: "T-Shirt", price: 15, category: "Clothing", image: "img/tshirt.jpg" },
        { id: 4, name: "Jeans", price: 40, category: "Clothing", image: "img/jeans.jpg" },
        { id: 5, name: "Milk", price: 2, category: "Groceries", image: "img/milk.jpg" },
        { id: 6, name: "Apples", price: 3, category: "Groceries", image: "img/apples.jpg" },
        { id: 7, name: "Bananas", price: 1.5, category: "Groceries", image: "img/bananas.jpg" },
        { id: 8, name: "Carrots", price: 2, category: "Groceries", image: "img/carrots.jpg" },
        { id: 9, name: "Chicken", price: 10, category: "Groceries", image: "img/chicken.jpg" }
    ];
    
    

    const productList = document.getElementById('product-list');
    const searchBar = document.getElementById('search-bar');
    const categoryFilter = document.getElementById('category-filter');
    const priceFilter = document.getElementById('price-filter');

    // Render products
    function renderProducts(productsToRender) {
        productList.innerHTML = "";
        productsToRender.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'col-md-4 mb-4';
            productCard.innerHTML = `
                <div class="card product-card">
                    <img src="${product.image}" class="card-img-top" alt="${product.name}">
                    <div class="card-body">
                        <h5 class="product-title">${product.name}</h5>
                        <p class="card-text">Category: ${product.category}</p>
                        <p class="card-text">Price: $${product.price.toFixed(2)}</p>
                        <button class="btn btn-primary add-to-cart" data-id="${product.id}" data-name="${product.name}" data-price="${product.price}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            `;
            productList.appendChild(productCard);
        });
    }

    // Add product to cart
    function addToCart(product) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const existingProduct = cart.find(item => item.id === product.id);
        if (existingProduct) {
            existingProduct.quantity += 1;
        } else {
            cart.push({ ...product, quantity: 1 });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        alert(`${product.name} has been added to your cart!`);
    }

    // Filter products
    function filterProducts() {
        let filteredProducts = [...products];
        const category = categoryFilter.value;
        const price = priceFilter.value;

        if (category) {
            filteredProducts = filteredProducts.filter(product => product.category === category);
        }

        if (price === "low") {
            filteredProducts = filteredProducts.filter(product => product.price < 20);
        } else if (price === "medium") {
            filteredProducts = filteredProducts.filter(product => product.price >= 20 && product.price <= 50);
        } else if (price === "high") {
            filteredProducts = filteredProducts.filter(product => product.price > 50);
        }

        renderProducts(filteredProducts);
    }

    // Search products
    searchBar.addEventListener('input', () => {
        const query = searchBar.value.toLowerCase();
        const filteredProducts = products.filter(product =>
            product.name.toLowerCase().includes(query) || product.category.toLowerCase().includes(query)
        );
        renderProducts(filteredProducts);
    });

    // Event listener for filters
    document.getElementById('apply-filters').addEventListener('click', filterProducts);

    // Event listener for "Add to Cart" buttons
    productList.addEventListener('click', (event) => {
        if (event.target.classList.contains('add-to-cart')) {
            const button = event.target;
            const product = {
                id: parseInt(button.dataset.id),
                name: button.dataset.name,
                price: parseFloat(button.dataset.price)
            };
            addToCart(product);
        }
    });

    // Initial rendering
    renderProducts(products);
});
