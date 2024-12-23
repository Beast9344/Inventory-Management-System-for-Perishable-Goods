<?php
// Include database connection file
include('connect.php');

// Check if employee_id is set and is a valid value
if (isset($_POST['employee_id']) && !empty($_POST['employee_id'])) {
    $employeeId = $_POST['employee_id'];

    // Prepare the DELETE query to delete the selected employee
    $query = "DELETE FROM employees WHERE employee_id = ?";

    if ($stmt = $conn->prepare($query)) {
        // Bind the employee_id to the prepared statement
        $stmt->bind_param('s', $employeeId);

        // Execute the query
        if ($stmt->execute()) {
            echo "Employee deleted successfully.";
        } else {
            echo "Error deleting employee.";
        }

        $stmt->close();
    } else {
        echo "Failed to prepare statement.";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
