 // Sample data to simulate alert records
const alertData = [
    { id: "A001", type: "Low Stock", description: "Stock for item X is below threshold", date: "2024-11-10", status: "Active" },
    { id: "A002", type: "Expired Product", description: "Item Y has expired", date: "2024-11-12", status: "Resolved" },
    { id: "A003", type: "Reorder Reminder", description: "Reorder needed for item Z", date: "2024-11-14", status: "Active" }
];

let selectedAlertId = null; // To store the currently selected alert ID for deletion
let selectedResolveId = null; // To store the currently selected alert ID for resolution

// Function to display alerts in the table
function displayAlerts() {
    const alertList = document.getElementById('alert-list');
    alertList.innerHTML = ''; // Clear the existing list

    alertData.forEach(alert => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${alert.id}</td>
            <td>${alert.type}</td>
            <td>${alert.description}</td>
            <td>${alert.date}</td>
            <td>${alert.status}</td>
            <td>
                <button class="btn btn-sm btn-info" onclick="viewDetails('${alert.id}')">View Details</button>
                <button class="btn btn-sm btn-success" onclick="prepareResolveAlert('${alert.id}')">Resolve</button>
                <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteAlertModal" onclick="prepareDeleteAlert('${alert.id}')">Remove</button>
            </td>
        `;
        alertList.appendChild(row);
    });
}

// Function to handle adding a new alert
function addAlert() {
    const alertType = document.getElementById('alert-type').value;
    const alertDescription = document.getElementById('alert-description').value;

    // Validate input fields
    if (!alertType || !alertDescription) {
        alert('Please fill in all fields.');
        return;
    }

    const newAlert = {
        id: `A${(alertData.length + 1).toString().padStart(3, '0')}`, // Generate unique ID
        type: alertType,
        description: alertDescription,
        date: new Date().toISOString().split('T')[0], // Current date in YYYY-MM-DD format
        status: "Active" // Default status
    };

    // Add the new alert to the alertData array
    alertData.push(newAlert);

    // Re-render the alerts table
    displayAlerts();

    // Clear the form fields
    document.getElementById('alert-type').value = '';
    document.getElementById('alert-description').value = '';

    // Close the modal
    $('#addAlertModal').modal('hide');
}

// Attach event listener to "Add Alert" button
document.getElementById('saveAddAlert').addEventListener('click', addAlert);


// Function to prepare an alert for deletion (opens the modal)
function prepareDeleteAlert(alertId) {
    selectedAlertId = alertId; // Store the ID of the alert to be deleted
}

// Function to remove an alert (triggered from the modal)
function removeAlert() {
    const index = alertData.findIndex(alert => alert.id === selectedAlertId);
    if (index > -1) {
        alertData.splice(index, 1); // Remove the alert from the array
        displayAlerts(); // Re-render the alert list
    }
    $('#deleteAlertModal').modal('hide'); // Close the modal
}

// Function to mark an alert as resolved (triggered from the modal)
function prepareResolveAlert(alertId) {
    selectedResolveId = alertId; // Store the ID of the alert to be resolved
    $('#resolveAlertModal').modal('show'); // Show the modal
}

// Function to resolve an alert
function resolveAlert() {
    const alert = alertData.find(alert => alert.id === selectedResolveId);
    if (alert) {
        alert.status = "Resolved"; // Mark the alert as resolved
        displayAlerts(); // Re-render the alert list
    }
    $('#resolveAlertModal').modal('hide'); // Close the modal
}

// Function to view alert details
function viewDetails(alertId) {
    const alert = alertData.find(alert => alert.id === alertId);
    if (alert) {
        const detailsContent = `
            <p><strong>Alert ID:</strong> ${alert.id}</p>
            <p><strong>Type:</strong> ${alert.type}</p>
            <p><strong>Description:</strong> ${alert.description}</p>
            <p><strong>Date:</strong> ${alert.date}</p>
            <p><strong>Status:</strong> ${alert.status}</p>
        `;
        document.getElementById('alertDetailsContent').innerHTML = detailsContent;
        $('#viewDetailsModal').modal('show'); // Show the modal
    }
}

// Attach event listener to the "Delete" button in the modal
document.getElementById('confirmDeleteAlert').addEventListener('click', removeAlert);

// Attach event listener to the "Resolve" button in the modal
document.getElementById('confirmResolveAlert').addEventListener('click', resolveAlert);

// Initial display of alerts
displayAlerts();
