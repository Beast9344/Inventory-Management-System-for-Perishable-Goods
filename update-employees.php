<?php
// Include database connection file
include('connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employeeId = $_POST['employee_id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $jobTitle = $_POST['job_title'];
    $location = $_POST['location'];
    $yearsOfService = $_POST['years_of_service'];

    // SQL query to update the employee
    $sql = "UPDATE employees SET 
            name = ?, 
            department = ?, 
            job_title = ?, 
            location = ?, 
            years_of_service = ? 
            WHERE employee_id = ?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdi", $name, $department, $jobTitle, $location, $yearsOfService, $employeeId);

    if ($stmt->execute()) {
        echo "Employee updated successfully.";
    } else {
        echo "Error updating employee: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
