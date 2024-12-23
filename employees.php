<?php
// Include database connection file
include('connect.php');

// Fetch employees from the database
$query = "SELECT * FROM employees";
$result = $conn->query($query);

// Initialize an array to store the fetched employees
$employees = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
} else {
    // If no employees found, return an empty array
    $employees = [];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Employees - Inventory Management System</title>

    <!-- Google Font: Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
   

       <!-- Ionicons -->
       <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
       <!-- overlayScrollbars -->
       <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">


   
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .dark-mode {
            background-color: #121212;
            color: #f8f9fa;
        }
        .dark-mode .card {
            background-color: #1e1e1e;
        }
        .main-sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            background-color: #343a40;
            width: 250px;
            z-index: 1030;
        }
        .wrapper {
            margin-left: 250px;
        }
        .content-wrapper {
            margin-left: 50px;
            padding: 20px;
        }
        .brand-link {
            height: 50px;
            padding: 5px 10px;
            display: flex;
            align-items: center;
        }
        .brand-link img {
            height: 60px;
            width: auto;
            margin-top: 40px;
            margin-bottom: 20px;
            padding: 5px 5px;
        }
        .brand-text {
            font-size: 14px;
            margin-left: 10px;
            margin-top: 20px;
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








        .nav-sidebar {
            display: flex;
            flex-direction: column;
            padding: 0;
        }
        .nav-sidebar .nav-item {
            width: 100%;
        }
        .nav-sidebar .nav-link {
            padding: 10px 15px;
            color: #ffffff;
            text-decoration: none;
        }
        .nav-sidebar .nav-link.active {
            background-color: #495057;
        }
        .search-container {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #fff;
        }
        .category-container button {
            width: 150px;
        }
        #dark-mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            cursor: pointer;
        }

        .nav-item {
            padding-left: 30px;
        }
       
 
        .minimum-height {
            min-height: calc(90vh - 104px);
        }

        .loading {
            display: none;
            text-align: center;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Dark Mode Toggle -->
        <!-- <div id="dark-mode-toggle" class="text-primary">
            <i class="fas fa-moon fa-2x"></i>
        </div> -->


            <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">

            <li class="nav-item d-none d-sm-inline-block">
                <a href="dashboard.php" class="nav-link">Home</a>
            </li>

        </ul>
    </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Inventory System</span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="inventory.php" class="nav-link">
                                <i class="nav-icon fas fa-cogs"></i>
                                <p>Inventory</p>
                            </a>
                        </li>
                        <li class="nav-item active">
                            <a href="employees.php" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>Employees</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reports.php" class="nav-link">
                                <i class="nav-icon fas fa-chart-line"></i>
                                <p>Reports</p>
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
        </aside>













<!-- Main Content -->
<div class="content-wrapper minimum-height">
    <div class="container mt-3">
        <div class="text-left mb-4">
            <h1>Employee Directory</h1>
            <p>Search and explore employee details</p>
        </div>

        <!-- Search Container -->
        <div class="card search-container p-3 mb-3">
            <h3>Search Employee</h3>
            <input type="text" id="employee-id" class="form-control mb-2" placeholder="Enter Employee ID">
            <button onclick="searchEmployee()" class="btn btn-light">Search</button>
        </div>

        <!-- Filters -->
        <h3 class="mb-3">Browse by Filter</h3>
        <div class="category-container d-flex justify-content-start mb-4">
            <button class="btn btn-outline-primary me-2" onclick="filterByCategory('Sales')">Sales</button>
            <button class="btn btn-outline-success me-2" onclick="filterByCategory('IT')">IT</button>
            <button class="btn btn-outline-danger me-2" onclick="filterByCategory('Marketing')">Marketing</button>
            <button class="btn btn-outline-warning me-2" onclick="filterByCategory('Admin')">Admin</button>
            <button class="btn btn-outline-dark me-2" onclick="filterByCategory('HR')">HR</button>
            <button class="btn btn-outline-secondary" id="show-all-employees-btn">All Employees</button>
        </div>






        <!-- Employee Table -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employee List</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addEmployeeModal">
                        <i class="fas fa-plus"></i> Add Employee
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects" id="employeeTable">
                    <thead>
                        <tr>
                            <th style="width: 10%">Employee ID</th>
                            <th style="width: 15%">Name</th>
                            <th style="width: 15%">Department</th>
                            <th style="width: 15%">Job Title</th>
                            <th style="width: 15%">Location</th>
                            <th style="width: 15%">Years Of Service</th>
                            <th style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                                <td><?php echo htmlspecialchars($employee['name']); ?></td>
                                <td><?php echo htmlspecialchars($employee['department']); ?></td>
                                <td><?php echo htmlspecialchars($employee['job_title']); ?></td>
                                <td><?php echo htmlspecialchars($employee['location']); ?></td>
                                <td><?php echo htmlspecialchars($employee['years_of_service']); ?> years</td>
                                <td>
                                    <button class="btn btn-info" 
                                        data-toggle="modal" 
                                        data-target="#viewEmployeeModal" 
                                        data-id="<?php echo $employee['employee_id']; ?>" 
                                        data-name="<?php echo htmlspecialchars($employee['name']); ?>" 
                                        data-department="<?php echo htmlspecialchars($employee['department']); ?>" 
                                        data-jobtitle="<?php echo htmlspecialchars($employee['job_title']); ?>" 
                                        data-location="<?php echo htmlspecialchars($employee['location']); ?>" 
                                        data-years="<?php echo htmlspecialchars($employee['years_of_service']); ?>">
                                        View
                                    </button>






                                    <button class="btn btn-danger" 
                                        data-toggle="modal" 
                                        data-target="#deleteEmployeeModal" 
                                        data-id="<?php echo $employee['employee_id']; ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>



    </div>
</div>




<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="add-employees.php" method="POST">
                    <div class="form-group">
                        <label for="addEmployeeId">Employee ID</label>
                        <input type="text" class="form-control" name="employee_id" id="addEmployeeId" required>
                    </div>
                    <div class="form-group">
                        <label for="addEmployeeName">Name</label>
                        <input type="text" class="form-control" name="name" id="addEmployeeName" required>
                    </div>
                    <div class="form-group">
                        <label for="addEmployeeDepartment">Department</label>
                        <input type="text" class="form-control" name="department" id="addEmployeeDepartment" required>
                    </div>
                    <div class="form-group">
                        <label for="addJobTitle">Job Title</label>
                        <input type="text" class="form-control" name="job_title" id="addJobTitle" required>
                    </div>
                    <div class="form-group">
                        <label for="addLocation">Location</label>
                        <input type="text" class="form-control" name="location" id="addLocation" required>
                    </div>
                    <div class="form-group">
                        <label for="addYearsOfService">Years of Service</label>
                        <input type="number" class="form-control" name="years_of_service" id="addYearsOfService" min="0" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Employee</button>
                </form>
            </div>
        </div>
    </div>
</div>





<!-- Edit Employee Modal -->
<!-- Edit Employee Modal -->
<div id="editEmployeeModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editEmployeeForm">
                    <input type="hidden" id="editEmployeeId" name="employee_id">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editEmployeeName">Name</label>
                            <input type="text" class="form-control" id="editEmployeeName" name="name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editEmployeeDepartment">Department</label>
                            <input type="text" class="form-control" id="editEmployeeDepartment" name="department" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="editEmployeeJobTitle">Job Title</label>
                            <input type="text" class="form-control" id="editEmployeeJobTitle" name="job_title" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="editEmployeeLocation">Location</label>
                            <input type="text" class="form-control" id="editEmployeeLocation" name="location" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="editEmployeeYears">Years of Service</label>
                        <input type="number" class="form-control" id="editEmployeeYears" name="years_of_service" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="saveEditEmployeeButton" class="btn btn-warning">Save Changes</button>
            </div>
        </div>
    </div>
</div>





<!-- Delete Employee Modal -->
<div class="modal fade" id="deleteEmployeeModal" tabindex="-1" aria-labelledby="deleteEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteEmployeeModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this employee?</p>
                <input type="hidden" id="deleteEmployeeId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteEmployeeButton" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- View Employee Modal -->
<div class="modal fade" id="viewEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="viewEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewEmployeeModalLabel">Employee Details</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="viewEmployeeId"></span></p>
                <p><strong>Name:</strong> <span id="viewEmployeeName"></span></p>
                <p><strong>Department:</strong> <span id="viewEmployeeDepartment"></span></p>
                <p><strong>Job Title:</strong> <span id="viewEmployeeJobTitle"></span></p>
                <p><strong>Location:</strong> <span id="viewEmployeeLocation"></span></p>
                <p><strong>Years of Service:</strong> <span id="viewEmployeeYearsOfService"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>








<!-- Footer -->
<footer class="main-footer">
    <strong>&copy; 2024 <a href="https://google.com">Employee Management System</a>.</strong>
    All rights reserved.
</footer>









<!-- JS includes -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>







<script>
    // Search Employee by ID
    function searchEmployee() {
        var searchId = $('#employee-id').val().trim();

        if (searchId === '') {
            alert('Please enter a valid Employee ID.');
            return;
        }

        // Iterate through the table rows and find the matching ID
        $('#employeeTable tbody tr').each(function () {
            var row = $(this);
            var employeeId = row.find('td:first').text().trim();

            if (employeeId === searchId) {
                row.show();
            } else {
                row.hide();
            }
        });
    }

    // Filter by Category (Department)
    function filterByCategory(category) {
        $('#employeeTable tbody tr').each(function () {
            var row = $(this);
            var department = row.find('td:nth-child(3)').text().trim();

            if (department === category) {
                row.show();
            } else {
                row.hide();
            }
        });
    }

    // Show All Employees
    $('#show-all-employees-btn').click(function () {
        $('#employeeTable tbody tr').show();
    });







    // View Employee Modal
    $('#viewEmployeeModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        // Extract data from the button's data-* attributes
        var employeeId = button.data('id');
        var name = button.data('name');
        var department = button.data('department');
        var jobTitle = button.data('jobtitle');
        var location = button.data('location');
        var yearsOfService = button.data('years');

        // Populate modal fields
        var modal = $(this);
        modal.find('#viewEmployeeId').text(employeeId);
        modal.find('#viewEmployeeName').text(name);
        modal.find('#viewEmployeeDepartment').text(department);
        modal.find('#viewEmployeeJobTitle').text(jobTitle);
        modal.find('#viewEmployeeLocation').text(location);
        modal.find('#viewEmployeeYearsOfService').text(yearsOfService);
    });

    // Delete Employee Modal
$('#deleteEmployeeModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var employeeId = button.data('id'); // Extract the employee_id from the data-* attribute
    var modal = $(this);

    // Set the hidden input value with the employee_id
    modal.find('#deleteEmployeeId').val(employeeId);
});

// When the confirm delete button is clicked
$('#confirmDeleteEmployeeButton').click(function () {
    var employeeId = $('#deleteEmployeeId').val(); // Get the employee_id from the modal

    // Send an AJAX request to delete the employee
    $.ajax({
        type: "POST",
        url: "delete-employees.php", // PHP script to handle deletion
        data: { employee_id: employeeId },
        success: function (response) {
            // Close the modal
            $('#deleteEmployeeModal').modal('hide');

            // Display the response message from the server
            alert(response);

            // Reload the page to reflect the changes
            location.reload();
        },
        error: function () {
            alert('Error deleting employee. Please try again.');
        }
    });
});







// Edit Employee Modal
// Edit Employee Modal
$('#editEmployeeModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal

    // Extract employee data from data-* attributes
    var employeeId = button.data('id');
    var name = button.data('name');
    var department = button.data('department');
    var jobTitle = button.data('jobtitle');
    var location = button.data('location');
    var yearsOfService = button.data('years');

    // Set the values in the modal fields
    $('#editEmployeeId').val(employeeId);
    $('#editEmployeeName').val(name);
    $('#editEmployeeDepartment').val(department);
    $('#editEmployeeJobTitle').val(jobTitle);
    $('#editEmployeeLocation').val(location);
    $('#editEmployeeYears').val(yearsOfService);
});

// When the save button is clicked in the modal
$('#saveEditEmployeeButton').click(function () {
    // Serialize the form data
    var formData = $('#editEmployeeForm').serialize();

    // Send an AJAX request to update the employee
    $.ajax({
        type: "POST",
        url: "update-employee.php", // PHP script to handle the update
        data: formData,
        success: function (response) {
            // Close the modal
            $('#editEmployeeModal').modal('hide');
            // Display the response message
            alert(response);

            // Reload the page or update the UI to reflect changes
            location.reload(); // Refresh the page to fetch updated data
        },
        error: function () {
            alert('Error updating employee.');
        }
    });
});




// Add Employee Modal
$('#saveAddEmployeeButton').click(function () {
    var formData = $('#addEmployeeForm').serializeArray(); // Serialize the form data
    var newEmployee = {
        employee_id: formData.find(field => field.name === 'employee_id').value,
        name: formData.find(field => field.name === 'name').value,
        department: formData.find(field => field.name === 'department').value,
        job_title: formData.find(field => field.name === 'job_title').value,
        location: formData.find(field => field.name === 'location').value,
        years_of_service: parseFloat(formData.find(field => field.name === 'years_of_service').value).toFixed(1)
    };

    // Simulate adding the new employee to the table
    $('#employeeTable tbody').append(`
        <tr>
            <td>${newEmployee.employee_id}</td>
            <td>${newEmployee.name}</td>
            <td>${newEmployee.department}</td>
            <td>${newEmployee.job_title}</td>
            <td>${newEmployee.location}</td>
            <td>${newEmployee.years_of_service} years</td>
            <td>
                <button class="btn btn-info" 
                    data-toggle="modal" 
                    data-target="#viewEmployeeModal" 
                    data-id="${newEmployee.employee_id}" 
                    data-name="${newEmployee.name}" 
                    data-department="${newEmployee.department}" 
                    data-jobtitle="${newEmployee.job_title}" 
                    data-location="${newEmployee.location}" 
                    data-years="${newEmployee.years_of_service}">
                    View
                </button>
                <button class="btn btn-warning" 
                    data-toggle="modal" 
                    data-target="#editEmployeeModal" 
                    data-id="${newEmployee.employee_id}" 
                    data-name="${newEmployee.name}" 
                    data-jobtitle="${newEmployee.job_title}" 
                    data-location="${newEmployee.location}">
                    Edit
                </button>
                <button class="btn btn-danger" 
                    data-toggle="modal" 
                    data-target="#deleteEmployeeModal" 
                    data-id="${newEmployee.employee_id}">
                    Delete
                </button>
            </td>
        </tr>
    `);

    // Close the modal
    $('#addEmployeeModal').modal('hide');

    // Debugging confirmation message
    alert('New employee has been added (simulated).');

    // Debugging message for backend issues
    console.error("Ensure your 'add-employees.php' script handles insertion in the database correctly.");
});








</script>



























</body>
</html>
