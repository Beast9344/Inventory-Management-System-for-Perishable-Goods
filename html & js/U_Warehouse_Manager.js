document.addEventListener("DOMContentLoaded", () => {
    // Sample warehouse data
    let warehouses = [
        { id: 1, name: "Warehouse A", location: "37.7749, -122.4194", capacity: 1000, stock: 500 },
        { id: 2, name: "Warehouse B", location: "34.0522, -118.2437", capacity: 1500, stock: 750 },
    ];

    const warehouseList = document.getElementById("warehouse-list");
    const addWarehouseForm = document.getElementById("add-warehouse-form");
    const editWarehouseForm = document.getElementById("editWarehouseForm");
    const deleteWarehouseBtn = document.getElementById("deleteWarehouseBtn");

    let editWarehouseId = null; // For tracking the warehouse being edited
    let markers = {}; // Store markers for each warehouse

    // Initialize map
    const map = L.map("warehouse-map").setView([37.7749, -122.4194], 5);
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
    }).addTo(map);

    // Function to render the warehouses table
    function renderWarehouses() {
        warehouseList.innerHTML = "";
        Object.values(markers).forEach((marker) => map.removeLayer(marker));
        markers = {}; // Clear existing markers

        warehouses.forEach((warehouse) => {
            const [lat, lng] = warehouse.location.split(",").map(Number);
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${warehouse.id}</td>
                <td>${warehouse.name}</td>
                <td>${warehouse.location}</td>
                <td>${warehouse.capacity}</td>
                <td>${warehouse.stock}</td>
                <td>
                    <button class="btn btn-sm btn-primary edit-btn" data-id="${warehouse.id}">Edit</button>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="${warehouse.id}">Delete</button>
                    <button class="btn btn-sm btn-success view-btn" data-id="${warehouse.id}">View on Map</button>
                </td>
            `;
            warehouseList.appendChild(row);

            // Add marker to the map
            const marker = L.marker([lat, lng])
                .addTo(map)
                .bindPopup(`<b>${warehouse.name}</b><br>Stock: ${warehouse.stock}`);
            markers[warehouse.id] = marker;
        });

        attachTableActions();
    }

    // Function to attach actions to Edit/Delete/View buttons
    function attachTableActions() {
        document.querySelectorAll(".edit-btn").forEach((button) => {
            button.addEventListener("click", (e) => {
                const id = Number(e.target.getAttribute("data-id"));
                const warehouse = warehouses.find((wh) => wh.id === id);

                if (warehouse) {
                    editWarehouseId = id;
                    document.getElementById("editWarehouseName").value = warehouse.name;
                    document.getElementById("editWarehouseLocation").value = warehouse.location;
                    document.getElementById("editWarehouseCapacity").value = warehouse.capacity;
                    document.getElementById("editWarehouseStock").value = warehouse.stock;

                    $("#editWarehouseModal").modal("show");
                }
            });
        });

        document.querySelectorAll(".delete-btn").forEach((button) => {
            button.addEventListener("click", (e) => {
                const id = Number(e.target.getAttribute("data-id"));
                editWarehouseId = id;

                $("#confirmDeleteModal").modal("show");
            });
        });

        document.querySelectorAll(".view-btn").forEach((button) => {
            button.addEventListener("click", (e) => {
                const id = Number(e.target.getAttribute("data-id"));
                const warehouse = warehouses.find((wh) => wh.id === id);

                if (warehouse) {
                    const [lat, lng] = warehouse.location.split(",").map(Number);
                    map.setView([lat, lng], 12); // Zoom in to the location
                    markers[warehouse.id].openPopup(); // Open the marker popup
                }
            });
        });
    }

    // Handle Add Warehouse form submission
    addWarehouseForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const name = document.getElementById("warehouse-name").value.trim();
        const location = document.getElementById("warehouse-location").value.trim();
        const capacity = Number(document.getElementById("warehouse-capacity").value);
        const stock = Number(document.getElementById("warehouse-stock").value);

        if (name && location && capacity >= 0 && stock >= 0) {
            const id = warehouses.length ? warehouses[warehouses.length - 1].id + 1 : 1;
            warehouses.push({ id, name, location, capacity, stock });

            renderWarehouses();
            addWarehouseForm.reset();
        } else {
            alert("Please fill in all fields with valid data.");
        }
    });

    // Handle Edit Warehouse form submission
    editWarehouseForm.addEventListener("submit", (e) => {
        e.preventDefault();

        const name = document.getElementById("editWarehouseName").value.trim();
        const location = document.getElementById("editWarehouseLocation").value.trim();
        const capacity = Number(document.getElementById("editWarehouseCapacity").value);
        const stock = Number(document.getElementById("editWarehouseStock").value);

        if (name && location && capacity >= 0 && stock >= 0) {
            const index = warehouses.findIndex((wh) => wh.id === editWarehouseId);
            if (index > -1) {
                warehouses[index] = { ...warehouses[index], name, location, capacity, stock };
                renderWarehouses();
                $("#editWarehouseModal").modal("hide");
            }
        } else {
            alert("Please fill in all fields with valid data.");
        }
    });

    // Handle Delete Warehouse confirmation
    deleteWarehouseBtn.addEventListener("click", () => {
        warehouses = warehouses.filter((wh) => wh.id !== editWarehouseId);
        renderWarehouses();
        $("#confirmDeleteModal").modal("hide");
    });

    // Initial render
    renderWarehouses();
});
