// Sample sales orders data
const salesOrders = [
    {
        orderId: '#10234',
        customerName: 'Jane Doe',
        orderDate: '2024-10-10',
        status: 'Completed',
        totalAmount: '$450.00'
    },
    {
        orderId: '#10235',
        customerName: 'John Smith',
        orderDate: '2024-10-15',
        status: 'Pending',
        totalAmount: '$220.00'
    },
    {
        orderId: '#10236',
        customerName: 'Mary Johnson',
        orderDate: '2024-10-20',
        status: 'Processing',
        totalAmount: '$330.00'
    },
    {
        orderId: '#10237',
        customerName: 'Robert Brown',
        orderDate: '2024-10-22',
        status: 'Cancelled',
        totalAmount: '$150.00'
    }
];

// Function to generate the Sales Orders table
function generateSalesOrderTable() {
    const tableBody = document.querySelector('table tbody');
    tableBody.innerHTML = ''; // Clear existing rows

    salesOrders.forEach(order => {
        const row = document.createElement('tr');

        // Create table data cells for each order field
        const orderIdCell = document.createElement('td');
        orderIdCell.textContent = order.orderId;

        const customerNameCell = document.createElement('td');
        customerNameCell.textContent = order.customerName;

        const orderDateCell = document.createElement('td');
        orderDateCell.textContent = order.orderDate;

        const statusCell = document.createElement('td');
        const statusBadge = document.createElement('span');
        statusBadge.classList.add('badge');
        switch (order.status) {
            case 'Completed':
                statusBadge.classList.add('bg-success');
                break;
            case 'Pending':
                statusBadge.classList.add('bg-warning');
                break;
            case 'Processing':
                statusBadge.classList.add('bg-info');
                break;
            case 'Cancelled':
                statusBadge.classList.add('bg-danger');
                break;
            default:
                statusBadge.classList.add('bg-secondary');
        }
        statusBadge.textContent = order.status;
        statusCell.appendChild(statusBadge);

        const totalAmountCell = document.createElement('td');
        totalAmountCell.textContent = order.totalAmount;

        const actionsCell = document.createElement('td');
        actionsCell.innerHTML = `
            <a class="btn btn-primary btn-sm" href="#" onclick="viewOrder('${order.orderId}')">
                <i class="fas fa-folder"></i> View
            </a>
            <a class="btn btn-info btn-sm" href="#" onclick="editOrder('${order.orderId}')">
                <i class="fas fa-pencil-alt"></i> Edit
            </a>
            <a class="btn btn-danger btn-sm" href="#" onclick="deleteOrder('${order.orderId}')">
                <i class="fas fa-trash"></i> Delete
            </a>
        `;

        // Append cells to the row
        row.appendChild(orderIdCell);
        row.appendChild(customerNameCell);
        row.appendChild(orderDateCell);
        row.appendChild(statusCell);
        row.appendChild(totalAmountCell);
        row.appendChild(actionsCell);

        // Append the row to the table body
        tableBody.appendChild(row);
    });
}

// Function to handle viewing an order
function viewOrder(orderId) {
    const order = salesOrders.find(o => o.orderId === orderId);
    if (order) {
        alert('Viewing details of order ' + orderId + ':\n' + JSON.stringify(order, null, 2));
        // You can replace alert with modal popup to display more details.
    }
}

// Function to handle editing an order
function editOrder(orderId) {
    const order = salesOrders.find(o => o.orderId === orderId);

    if (order) {
        // Fill the form fields with the existing order data
        document.getElementById('editOrderId').value = order.orderId;
        document.getElementById('editCustomerName').value = order.customerName;
        document.getElementById('editOrderDate').value = order.orderDate;
        document.getElementById('editStatus').value = order.status;
        document.getElementById('editTotalAmount').value = order.totalAmount;

        // Show the modal
        $('#editOrderModal').modal('show');

        // Save changes when the "Save changes" button is clicked
        document.getElementById('saveEditButton').onclick = function () {
            const updatedOrder = {
                orderId: document.getElementById('editOrderId').value,
                customerName: document.getElementById('editCustomerName').value,
                orderDate: document.getElementById('editOrderDate').value,
                status: document.getElementById('editStatus').value,
                totalAmount: document.getElementById('editTotalAmount').value
            };

            // Update the order in the salesOrders array
            const index = salesOrders.findIndex(o => o.orderId === orderId);
            if (index !== -1) {
                salesOrders[index] = updatedOrder;
                generateSalesOrderTable(); // Re-render the table after update
                $('#editOrderModal').modal('hide'); // Close the modal
            }
        };
    }
}

// Function to handle deleting an order
function deleteOrder(orderId) {
    if (confirm('Are you sure you want to delete order ' + orderId + '?')) {
        // Filter out the deleted order from the salesOrders array
        const index = salesOrders.findIndex(order => order.orderId === orderId);
        if (index !== -1) {
            salesOrders.splice(index, 1);
            generateSalesOrderTable(); // Re-render the table after deletion
            alert('Order ' + orderId + ' deleted successfully.');
        }
    }
}

// Function to handle adding a new order
function addOrder() {
    const orderId = document.getElementById('addOrderId').value;
    const customerName = document.getElementById('addCustomerName').value;
    const orderDate = document.getElementById('addOrderDate').value;
    const status = document.getElementById('addStatus').value;
    const totalAmount = document.getElementById('addTotalAmount').value;

    // Validate input fields
    if (!orderId || !customerName || !orderDate || !status || !totalAmount) {
        alert('Please fill in all fields.');
        return;
    }

    const newOrder = {
        orderId: orderId,
        customerName: customerName,
        orderDate: orderDate,
        status: status,
        totalAmount: totalAmount
    };

    // Add the new order to the salesOrders array
    salesOrders.push(newOrder);
    generateSalesOrderTable(); // Re-render the table
    $('#addOrderModal').modal('hide'); // Close the modal
}

// Initializing the sales orders table when the page loads
document.addEventListener('DOMContentLoaded', () => {
    generateSalesOrderTable();
});

// Event listener for the Add Order button in the modal
document.getElementById('saveAddButton').addEventListener('click', addOrder);
