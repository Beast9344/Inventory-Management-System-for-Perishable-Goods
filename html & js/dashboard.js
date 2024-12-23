// Function to simulate real-time updates for dashboard metrics
function updateDashboard() {
    // Retrieve data from localStorage or use default values if not available
    let newOrders = localStorage.getItem('newOrders') || 150;  // Example value for New Orders
    let bounceRate = localStorage.getItem('bounceRate') || 53;  // Example value for Bounce Rate
    let userRegistrations = localStorage.getItem('userRegistrations') || 44;  // Example value for User Registrations
    let uniqueVisitors = localStorage.getItem('uniqueVisitors') || 65;  // Example value for Unique Visitors
    let weeklySales = JSON.parse(localStorage.getItem('weeklySales')) || [12, 19, 3, 5, 2, 3, 7]; // Example weekly sales data
    let monthlySales = JSON.parse(localStorage.getItem('monthlySales')) || [50, 60, 70, 80, 55, 50, 45, 60, 65, 70, 85, 90]; // Example monthly sales data
    let stockAlerts = JSON.parse(localStorage.getItem('stockAlerts')) || [
        { product: 'Milk', message: 'Expiry Date: 2024-11-20' },
        { product: 'Cheese', message: 'Low Stock (10 units remaining)' },
        { product: 'Butter', message: 'Expiry Date: 2024-11-15' }
    ];
    let latestOrders = JSON.parse(localStorage.getItem('latestOrders')) || [
        { orderId: '#101', customer: 'John Doe' },
        { orderId: '#102', customer: 'Jane Smith' },
        { orderId: '#103', customer: 'Mark Brown' }
    ];

    // Update the HTML elements with the new data
    document.getElementById('newOrdersCount').textContent = newOrders;
    document.getElementById('bounceRatePercent').textContent = bounceRate + '%';
    document.getElementById('userRegistrationsCount').textContent = userRegistrations;
    document.getElementById('uniqueVisitorsCount').textContent = uniqueVisitors;

    // Update Weekly Sales Chart data
    updateWeeklySalesChart(weeklySales);

    // Update Monthly Sales Chart data
    updateMonthlySalesChart(monthlySales);

    // Update Stock Alerts data
    updateStockAlerts(stockAlerts);

    // Update Latest Orders data
    updateLatestOrders(latestOrders);
}

// Call the function to update the dashboard when the page loads
window.onload = function() {
    updateDashboard();
};

// Function to allow editing the data dynamically for the metrics
function updateData(newOrdersVal, bounceRateVal, userRegsVal, uniqueVisitorsVal, weeklySales, monthlySales, stockAlerts, latestOrders) {
    // Update the displayed values on the page
    document.getElementById('newOrdersCount').textContent = newOrdersVal;
    document.getElementById('bounceRatePercent').textContent = bounceRateVal + '%';
    document.getElementById('userRegistrationsCount').textContent = userRegsVal;
    document.getElementById('uniqueVisitorsCount').textContent = uniqueVisitorsVal;

    // Save the updated values to localStorage for persistence
    localStorage.setItem('newOrders', newOrdersVal);
    localStorage.setItem('bounceRate', bounceRateVal);
    localStorage.setItem('userRegistrations', userRegsVal);
    localStorage.setItem('uniqueVisitors', uniqueVisitorsVal);
    localStorage.setItem('weeklySales', JSON.stringify(weeklySales));
    localStorage.setItem('monthlySales', JSON.stringify(monthlySales));
    localStorage.setItem('stockAlerts', JSON.stringify(stockAlerts));
    localStorage.setItem('latestOrders', JSON.stringify(latestOrders));

    // Update the charts and lists after saving new data
    updateWeeklySalesChart(weeklySales);
    updateMonthlySalesChart(monthlySales);
    updateStockAlerts(stockAlerts);
    updateLatestOrders(latestOrders);
}

// Function to update Weekly Sales Chart data
function updateWeeklySalesChart(weeklySales) {
    var ctxWeekly = document.getElementById('weeklySalesChart').getContext('2d');
    var weeklySalesChart = new Chart(ctxWeekly, {
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
}

// Function to update Monthly Sales Chart data
function updateMonthlySalesChart(monthlySales) {
    var ctxMonthly = document.getElementById('monthlySalesChart').getContext('2d');
    var monthlySalesChart = new Chart(ctxMonthly, {
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

// Function to update Stock Alerts data
function updateStockAlerts(stockAlerts) {
    let stockAlertsContainer = document.getElementById('stockAlertsList');
    stockAlertsContainer.innerHTML = ''; // Clear the current list

    stockAlerts.forEach(alert => {
        let listItem = document.createElement('li');
        listItem.textContent = `${alert.product} - ${alert.message}`;
        stockAlertsContainer.appendChild(listItem);
    });
}

// Function to update Latest Orders data
function updateLatestOrders(latestOrders) {
    let ordersContainer = document.getElementById('latestOrdersList');
    ordersContainer.innerHTML = ''; // Clear the current list

    latestOrders.forEach(order => {
        let listItem = document.createElement('li');
        listItem.textContent = `Order ${order.orderId} - Customer: ${order.customer}`;
        ordersContainer.appendChild(listItem);
    });
}

// Event listener for form submission (to update the dashboard)
document.getElementById('dataForm').addEventListener('submit', function(event) {
    event.preventDefault();

    // Get values from form inputs
    let newOrdersVal = parseInt(document.getElementById('newOrdersInput').value);
    let bounceRateVal = parseInt(document.getElementById('bounceRateInput').value);
    let userRegsVal = parseInt(document.getElementById('userRegistrationsInput').value);
    let uniqueVisitorsVal = parseInt(document.getElementById('uniqueVisitorsInput').value);

    // Get values for Weekly Sales, Monthly Sales, Stock Alerts, Latest Orders from form inputs
    let weeklySales = document.getElementById('weeklySalesInput').value.split(',').map(item => parseInt(item.trim()));
    let monthlySales = document.getElementById('monthlySalesInput').value.split(',').map(item => parseInt(item.trim()));
    let stockAlerts = JSON.parse(document.getElementById('stockAlertsInput').value || '[]');
    let latestOrders = JSON.parse(document.getElementById('latestOrdersInput').value || '[]');

    // Update dashboard and localStorage with new values
    updateData(newOrdersVal, bounceRateVal, userRegsVal, uniqueVisitorsVal, weeklySales, monthlySales, stockAlerts, latestOrders);
});
