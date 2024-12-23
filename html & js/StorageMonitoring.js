// Initial storage data with environmental controls
let storageData = {
    primary: {
        capacity: 5000,
        used: 800,
        temperature: 20,
        humidity: 45,
        targetTemp: 20,
        targetHumidity: 45,
        items: [
            { name: 'Rice', quantity: 500, unit: 'kg' },
            { name: 'Wheat', quantity: 300, unit: 'kg' }
        ]
    },
    backup: {
        capacity: 3000,
        used: 350,
        temperature: 20,
        humidity: 45,
        targetTemp: 20,
        targetHumidity: 45,
        items: [
            { name: 'Sugar', quantity: 250, unit: 'kg' },
            { name: 'Salt', quantity: 100, unit: 'kg' }
        ]
    }
};

// Environmental settings for different items
const itemSettings = {
    'Rice': { temp: 15, humidity: 60 },
    'Wheat': { temp: 18, humidity: 55 },
    'Sugar': { temp: 20, humidity: 35 },
    'Salt': { temp: 22, humidity: 40 },
    'Corn': { temp: 16, humidity: 50 },
    'Beans': { temp: 17, humidity: 45 },
    'Coffee': { temp: 21, humidity: 55 },
    'Tea': { temp: 19, humidity: 50 }
};

// Function to update storage display
function updateStorageDisplay(storageType) {
    const storage = storageData[storageType];
    const cardIndex = storageType === 'backup' ? 1 : 0;
    const card = document.querySelectorAll('.card')[cardIndex];

    // Update progress bar and usage text
    const progressBar = card.querySelector('.progress');
    const usageText = card.querySelector('.progress-bar + div');
    const usagePercentage = (storage.used / storage.capacity) * 100;
    
    progressBar.style.width = `${usagePercentage.toFixed(1)}%`;
    usageText.textContent = `${usagePercentage.toFixed(1)}% Used (${storage.used}/${storage.capacity} kg)`;

    // Update temperature and humidity displays
    const metricBoxes = card.querySelectorAll('.metric-box');
    metricBoxes[0].querySelector('div:last-child').textContent = `${storage.temperature.toFixed(1)}°C`;
    metricBoxes[1].querySelector('div:last-child').textContent = `${storage.humidity.toFixed(1)}%`;

    // Update inventory items
    const inventoryGrid = card.querySelector('.inventory-grid');
    inventoryGrid.innerHTML = storage.items.map(item => `
        <div class="inventory-item">
            <span>${item.name}: ${item.quantity} ${item.unit}</span>
            <div class="item-controls">
                <button class="edit-btn" onclick="editItem('${storageType}', '${item.name}')">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="remove-btn" onclick="confirmRemoval('${storageType}', '${item.name}')">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `).join('');
}

// Function to update environmental controls
function updateEnvironmentalControls(storageType) {
    const storage = storageData[storageType];
    
    if (storage.items.length === 0) {
        storage.targetTemp = 20;
        storage.targetHumidity = 45;
    } else {
        let totalWeight = 0;
        let tempSum = 0;
        let humiditySum = 0;

        storage.items.forEach(item => {
            const settings = itemSettings[item.name];
            totalWeight += item.quantity;
            tempSum += settings.temp * item.quantity;
            humiditySum += settings.humidity * item.quantity;
        });

        storage.targetTemp = Math.round(tempSum / totalWeight);
        storage.targetHumidity = Math.round(humiditySum / totalWeight);
    }

    adjustEnvironment(storageType);
}

// Function to gradually adjust temperature and humidity
function adjustEnvironment(storageType) {
    const storage = storageData[storageType];
    const ADJUSTMENT_INTERVAL = 1000; // 1 second
    const TEMP_STEP = 0.1;
    const HUMIDITY_STEP = 0.1;

    // Adjust temperature
    if (Math.abs(storage.temperature - storage.targetTemp) > 0.1) {
        storage.temperature += storage.temperature < storage.targetTemp ? TEMP_STEP : -TEMP_STEP;
    }

    // Adjust humidity
    if (Math.abs(storage.humidity - storage.targetHumidity) > 0.1) {
        storage.humidity += storage.humidity < storage.targetHumidity ? HUMIDITY_STEP : -HUMIDITY_STEP;
    }

    updateStorageDisplay(storageType);

    // Continue adjusting if not at target
    if (Math.abs(storage.temperature - storage.targetTemp) > 0.1 || 
        Math.abs(storage.humidity - storage.targetHumidity) > 0.1) {
        setTimeout(() => adjustEnvironment(storageType), ADJUSTMENT_INTERVAL);
    }
}

// Function to show alerts
function showAlert(message, type = 'success') {
    const alert = document.createElement('div');
    alert.className = `alert alert-${type}`;
    alert.textContent = message;
    document.body.appendChild(alert);

    setTimeout(() => alert.remove(), 3000);
}

// Function to add new item
function addItem(event) {
    const addForm = event.target.closest('.add-form');
    const card = addForm.closest('.card');
    const storageType = card === document.querySelectorAll('.card')[0] ? 'primary' : 'backup';
    const storage = storageData[storageType];

    const nameInput = addForm.querySelector('.good-name');
    const quantityInput = addForm.querySelector('.good-quantity');
    const unitSelect = addForm.querySelector('.good-unit');

    const name = nameInput.value;
    const quantity = parseInt(quantityInput.value);
    const unit = unitSelect.value;

    if (!name || !quantity || isNaN(quantity)) {
        showAlert('Please fill in all fields correctly', 'error');
        return;
    }

    if (storage.used + quantity > storage.capacity) {
        showAlert('Not enough storage capacity!', 'error');
        return;
    }

    storage.items.push({ name, quantity, unit });
    storage.used += quantity;

    // Reset form
    nameInput.value = '';
    quantityInput.value = '';
    unitSelect.selectedIndex = 0;

    updateEnvironmentalControls(storageType);
    showAlert(`Added ${quantity} ${unit} of ${name} successfully`);
}

// Function to confirm removal
function confirmRemoval(storageType, itemName) {
    if (confirm(`Are you sure you want to remove ${itemName}?`)) {
        const storage = storageData[storageType];
        const itemIndex = storage.items.findIndex(item => item.name === itemName);
        
        if (itemIndex !== -1) {
            const removedQuantity = storage.items[itemIndex].quantity;
            storage.used -= removedQuantity;
            storage.items.splice(itemIndex, 1);
            
            updateEnvironmentalControls(storageType);
            showAlert(`Removed ${itemName} successfully`);
        }
    }
}

// Function to edit item
function editItem(storageType, itemName) {
    const storage = storageData[storageType];
    const item = storage.items.find(item => item.name === itemName);
    
    if (!item) return;

    const newQuantity = prompt(`Enter new quantity for ${itemName} (current: ${item.quantity} ${item.unit}):`, item.quantity);
    
    if (newQuantity === null) return;
    
    const quantity = parseInt(newQuantity);
    
    if (isNaN(quantity) || quantity < 0) {
        showAlert('Please enter a valid quantity', 'error');
        return;
    }

    const quantityDiff = quantity - item.quantity;
    if (storage.used + quantityDiff > storage.capacity) {
        showAlert('Not enough storage capacity!', 'error');
        return;
    }

    storage.used += quantityDiff;
    item.quantity = quantity;

    updateEnvironmentalControls(storageType);
    showAlert(`Updated ${itemName} quantity to ${quantity} ${item.unit}`);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    // Add event listeners to Add buttons
    document.querySelectorAll('.add-form button').forEach(button => {
        button.addEventListener('click', addItem);
    });

    // Initialize displays and start environmental control
    updateEnvironmentalControls('primary');
    updateEnvironmentalControls('backup');
});