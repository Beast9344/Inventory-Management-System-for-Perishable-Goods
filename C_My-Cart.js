document.addEventListener('DOMContentLoaded', () => {
    const checkoutButton = document.getElementById('checkoutButton');
    const paymentOptions = document.querySelector('.payment-options');
    const paymentStatus = document.getElementById('paymentStatus');
    const subtotalDisplay = document.getElementById('subtotal');
    const taxDisplay = document.getElementById('tax');
    const totalDisplay = document.getElementById('total');

    function loadCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        renderCart(cart);
    }

    function renderCart(cart) {
        const cartItemsContainer = document.getElementById('cartItems');
        cartItemsContainer.innerHTML = "";
        let subtotal = 0;

        cart.forEach(item => {
            const itemSubtotal = item.price * item.quantity;
            subtotal += itemSubtotal;

            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${item.name}</td>

                <td>$${item.price.toFixed(2)}</td>
                <td>
                    <input type="number" class="form-control quantity-input" data-id="${item.id}" value="${item.quantity}" min="1">
                </td>
                <td>$${itemSubtotal.toFixed(2)}</td>
                <td class="cart-action-btns">
                    <button class="btn btn-danger btn-sm remove-btn" data-id="${item.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            cartItemsContainer.appendChild(row);
        });

        const tax = subtotal * 0.1;
        const total = subtotal + tax;

        subtotalDisplay.textContent = subtotal.toFixed(2);
        taxDisplay.textContent = tax.toFixed(2);
        totalDisplay.textContent = total.toFixed(2);

        attachEventListeners(cart);
    }

    function attachEventListeners(cart) {
        // Remove item from cart
        const removeButtons = document.querySelectorAll('.remove-btn');
        removeButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                const itemId = parseInt(event.target.closest('button').dataset.id);
                const updatedCart = cart.filter(item => item.id !== itemId);
                localStorage.setItem('cart', JSON.stringify(updatedCart));
                renderCart(updatedCart);
            });
        });

        // Update item quantity
        const quantityInputs = document.querySelectorAll('.quantity-input');
        quantityInputs.forEach(input => {
            input.addEventListener('change', (event) => {
                const itemId = parseInt(event.target.dataset.id);
                const newQuantity = parseInt(event.target.value);
                if (newQuantity < 1) {
                    alert("Quantity cannot be less than 1.");
                    event.target.value = 1;
                    return;
                }

                const updatedCart = cart.map(item => {
                    if (item.id === itemId) {
                        item.quantity = newQuantity;
                    }
                    return item;
                });

                localStorage.setItem('cart', JSON.stringify(updatedCart));
                renderCart(updatedCart);
            });
        });
    }








    function generateOrderId() {
        return Math.floor(Math.random() * 1e8); // Generate a random integer up to 8 digits
    }

    checkoutButton.addEventListener('click', () => {
        paymentOptions.style.display = 'block'; // Show payment options
    });

    ['creditCardBtn', 'paypalBtn', 'applePayBtn', 'cashOnDeliveryBtn'].forEach(id => {
        document.getElementById(id).addEventListener('click', () => processPayment(id.replace('Btn', '')));
    });

















    function processPayment(paymentMethod) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        if (cart.length === 0) {
            alert("Your cart is empty!");
            return;
        }
    
        const orderId = generateOrderId();
        const totalAmount = parseFloat(totalDisplay.textContent);
    
        const formData = new URLSearchParams();
        formData.append('order_id', orderId);
        formData.append('cart', JSON.stringify(cart)); // Pass the entire cart
        formData.append('payment_method', paymentMethod);
        formData.append('total', totalAmount.toFixed(2));
    
        fetch('add-order_items.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData.toString()
        })
        .then(response => response.text())
        .then(data => {
            if (data.includes("Error")) {
                alert("Error processing payment: " + data);
            } else {
                paymentStatus.style.display = 'block';
                paymentStatus.classList.add('success');
                paymentStatus.textContent = `Order ${orderId}: Payment of $${totalAmount.toFixed(2)} via ${paymentMethod} was successful!`;
                
                localStorage.removeItem('cart'); // Clear the cart
                renderCart([]); // Re-render cart with no items
            }
        })
        .catch(error => {
            alert("An error occurred: " + error.message);
        });
    }
    






    
    loadCart();
});
