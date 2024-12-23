<!-- Add Employee Backend Code -->
<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employeeId = $_POST['employee_id'];
    $name = $_POST['name'];
    $department = $_POST['department'];
    $jobTitle = $_POST['job_title'];
    $location = $_POST['location'];
    $yearsOfService = $_POST['years_of_service'];

    $sql = "INSERT INTO employees (employee_id, name, department, job_title, location, years_of_service) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $employeeId, $name, $department, $jobTitle, $location, $yearsOfService);

    if ($stmt->execute()) {
        echo "Employees added successfully.";

        // Redirect to employees.php after successful insertion

        header("Location: employees.php");
        exit(); // Stop further script execution
    } else {
        echo "Error adding Employees:  " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>