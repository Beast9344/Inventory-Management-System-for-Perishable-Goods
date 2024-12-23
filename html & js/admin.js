// Function to load existing data from localStorage and populate the form
function loadDashboardData() {
    // Get data from localStorage, if available, otherwise default to 0 or empty array
    const newOrders = localStorage.getItem('newOrders') || 0;
    const bounceRate = localStorage.getItem('bounceRate') || 0;
    const userRegistrations = localStorage.getItem('userRegistrations') || 0;
    const uniqueVisitors = localStorage.getItem('uniqueVisitors') || 0;
    const weeklySales = JSON.parse(localStorage.getItem('weeklySales')) || [0, 0, 0, 0, 0, 0, 0];
    const monthlySales = JSON.parse(localStorage.getItem('monthlySales')) || [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    const stockAlerts = JSON.parse(localStorage.getItem('stockAlerts')) || [];
    const latestOrders = JSON.parse(localStorage.getItem('latestOrders')) || [];

    // Update the form fields with current data
    document.getElementById('newOrdersInput').value = newOrders;
    document.getElementById('bounceRateInput').value = bounceRate;
    document.getElementById('userRegistrationsInput').value = userRegistrations;
    document.getElementById('uniqueVisitorsInput').value = uniqueVisitors;
    document.getElementById('weeklySalesInput').value = weeklySales.join(',');
    document.getElementById('monthlySalesInput').value = monthlySales.join(',');
    document.getElementById('stockAlertsInput').value = JSON.stringify(stockAlerts, null, 2);
    document.getElementById('latestOrdersInput').value = JSON.stringify(latestOrders, null, 2);

    // Update the displayed values on the page
    document.getElementById('currentNewOrders').textContent = newOrders;
    document.getElementById('currentBounceRate').textContent = bounceRate + '%';
    document.getElementById('currentUserRegistrations').textContent = userRegistrations;
    document.getElementById('currentUniqueVisitors').textContent = uniqueVisitors;

    // Display Stock Alerts
    const stockAlertsContainer = document.getElementById('currentStockAlerts');
    stockAlertsContainer.innerHTML = '';
    stockAlerts.forEach(alert => {
        const listItem = document.createElement('li');
        listItem.textContent = `${alert.product} - ${alert.message}`;
        stockAlertsContainer.appendChild(listItem);
    });

    // Display Latest Orders
    const latestOrdersContainer = document.getElementById('currentLatestOrders');
    latestOrdersContainer.innerHTML = '';
    latestOrders.forEach(order => {
        const listItem = document.createElement('li');
        listItem.textContent = `Order ${order.orderId} - Customer: ${order.customer}`;
        latestOrdersContainer.appendChild(listItem);
    });

    // Update the charts with the latest data
    updateSalesCharts(weeklySales, monthlySales);
}

// Update the charts for Weekly and Monthly Sales
function updateSalesCharts(weeklySales, monthlySales) {
    const ctxWeekly = document.getElementById('weeklySalesChart').getContext('2d');
    new Chart(ctxWeekly, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales',
                data: weeklySales,
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                borderColor: 'rgba(0, 123, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const ctxMonthly = document.getElementById('monthlySalesChart').getContext('2d');
    new Chart(ctxMonthly, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Sales',
                data: monthlySales,
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Handle form submission to update the data
document.getElementById('updateForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get the updated values from the form
    const newOrders = document.getElementById('newOrdersInput').value;
    const bounceRate = document.getElementById('bounceRateInput').value;
    const userRegistrations = document.getElementById('userRegistrationsInput').value;
    const uniqueVisitors = document.getElementById('uniqueVisitorsInput').value;
    const weeklySales = document.getElementById('weeklySalesInput').value.split(',').map(item => parseInt(item.trim()));
    const monthlySales = document.getElementById('monthlySalesInput').value.split(',').map(item => parseInt(item.trim()));
    const stockAlerts = JSON.parse(document.getElementById('stockAlertsInput').value || '[]');
    const latestOrders = JSON.parse(document.getElementById('latestOrdersInput').value || '[]');

    // Validate that data is correctly entered
    if (isNaN(newOrders) || isNaN(bounceRate) || isNaN(userRegistrations) || isNaN(uniqueVisitors)) {
        alert('Please enter valid numbers for all fields.');
        return;
    }

    // Save the updated data to localStorage
    localStorage.setItem('newOrders', newOrders);
    localStorage.setItem('bounceRate', bounceRate);
    localStorage.setItem('userRegistrations', userRegistrations);
    localStorage.setItem('uniqueVisitors', uniqueVisitors);
    localStorage.setItem('weeklySales', JSON.stringify(weeklySales));
    localStorage.setItem('monthlySales', JSON.stringify(monthlySales));
    localStorage.setItem('stockAlerts', JSON.stringify(stockAlerts));
    localStorage.setItem('latestOrders', JSON.stringify(latestOrders));

    // Refresh the displayed data on the form and dashboard
    loadDashboardData();

    // Show the confirmation message
    showConfirmationModal('Dashboard data updated successfully!');
});

// Custom function to show confirmation popup (modal)
function showConfirmationModal(message) {
    // Set the confirmation message
    document.getElementById('confirmationMessage').textContent = message;

    // Show the modal
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    confirmationModal.show();
}

// Load data when the page loads
window.onload = function() {
    loadDashboardData();
};
