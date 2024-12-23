// Mock employee data
const employeeData = [
    { id: "E001", name: "Alice Johnson", department: "Sales", phone: "555-1234", jobTitle: "Sales Manager", location: "New York", yearsOfService: 5 },
    { id: "E002", name: "Bob Smith", department: "IT", phone: "555-5678", jobTitle: "Software Developer", location: "San Francisco", yearsOfService: 3 },
    { id: "E003", name: "Charlie Brown", department: "Marketing", phone: "555-8765", jobTitle: "Marketing Specialist", location: "Chicago", yearsOfService: 2 },
    { id: "E004", name: "David Williams", department: "Admin", phone: "555-4321", jobTitle: "HR Manager", location: "Los Angeles", yearsOfService: 7 },
    { id: "E005", name: "Emily Davis", department: "HR", phone: "555-7890", jobTitle: "Recruiter", location: "Seattle", yearsOfService: 4 },
    { id: "E006", name: "Frank Thomas", department: "Sales", phone: "555-6543", jobTitle: "Account Executive", location: "New York", yearsOfService: 6 },
    { id: "E007", name: "Grace Miller", department: "IT", phone: "555-3456", jobTitle: "Systems Analyst", location: "San Francisco", yearsOfService: 5 },
    { id: "E008", name: "Hannah Taylor", department: "Marketing", phone: "555-8764", jobTitle: "Brand Manager", location: "Chicago", yearsOfService: 3 },
    { id: "E009", name: "Ian Wilson", department: "Admin", phone: "555-6789", jobTitle: "Operations Manager", location: "Los Angeles", yearsOfService: 8 },
    { id: "E010", name: "Julia Moore", department: "HR", phone: "555-2345", jobTitle: "HR Specialist", location: "Seattle", yearsOfService: 2 },
    { id: "E011", name: "Kevin Garcia", department: "Sales", phone: "555-9876", jobTitle: "Sales Representative", location: "New York", yearsOfService: 4 },
    { id: "E012", name: "Laura Hernandez", department: "IT", phone: "555-3210", jobTitle: "Network Engineer", location: "San Francisco", yearsOfService: 6 },
    { id: "E013", name: "Michael Anderson", department: "Marketing", phone: "555-7654", jobTitle: "Social Media Manager", location: "Chicago", yearsOfService: 2 },
    { id: "E014", name: "Natalie Martinez", department: "Admin", phone: "555-5432", jobTitle: "Executive Assistant", location: "Los Angeles", yearsOfService: 9 },
    { id: "E015", name: "Oliver Brown", department: "HR", phone: "555-8763", jobTitle: "HR Generalist", location: "Seattle", yearsOfService: 3 },
    { id: "E016", name: "Pamela Jackson", department: "Sales", phone: "555-6541", jobTitle: "Sales Coordinator", location: "New York", yearsOfService: 5 },
    { id: "E017", name: "Quentin Lee", department: "IT", phone: "555-9870", jobTitle: "Data Analyst", location: "San Francisco", yearsOfService: 4 },
    { id: "E018", name: "Rachel Clark", department: "Marketing", phone: "555-4323", jobTitle: "Content Strategist", location: "Chicago", yearsOfService: 1 },
    { id: "E019", name: "Steven Harris", department: "Admin", phone: "555-7653", jobTitle: "Administrative Assistant", location: "Los Angeles", yearsOfService: 6 },
    { id: "E020", name: "Tina Evans", department: "HR", phone: "555-3214", jobTitle: "Compensation Analyst", location: "Seattle", yearsOfService: 7 }
];

document.addEventListener('DOMContentLoaded', function () {
    // Sidebar toggle (AdminLTE functionality is handled by its script)
    const pushMenuLink = document.querySelector('[data-widget="pushmenu"]');
    if (pushMenuLink) {
        pushMenuLink.addEventListener('click', function () {
            // AdminLTE should handle the sidebar toggle, no additional code required here
        });
    }

    // Dark Mode Toggle
    const darkModeToggle = document.getElementById("dark-mode-toggle");
    darkModeToggle.addEventListener("click", () => {
        document.body.classList.toggle("dark-mode");
        darkModeToggle.querySelector("i").classList.toggle("fa-sun");
        darkModeToggle.querySelector("i").classList.toggle("fa-moon");
    });

});


// Toggle employees display on "All Employees" button click
let showAll = false;
document.getElementById('show-all-employees-btn').addEventListener('click', () => {
    showAll = !showAll;
    if (showAll) {
        displayEmployeeList(employeeData);
    } else {
        document.getElementById('filtered-employees').innerHTML = '';
    }
});

// Filter employees by department
function filterByCategory(department) {
    const filteredEmployees = employeeData.filter(emp => emp.department.toLowerCase() === department.toLowerCase());
    displayEmployeeList(filteredEmployees);
}

// Search employee by ID
function searchEmployee() {
    const employeeId = document.getElementById('employee-id').value.trim();
    if (!employeeId) {
        alert("Please enter an Employee ID.");
        return;
    }

    const employee = employeeData.find(emp => emp.id.toLowerCase() === employeeId.toLowerCase());
    if (employee) {
        displayEmployeeList([employee]);
    } else {
        alert("Employee not found.");
        document.getElementById('filtered-employees').innerHTML = '<p>No employees found.</p>';
    }
}

// Display employee list
function displayEmployeeList(employees) {
    const container = document.getElementById('filtered-employees');
    container.innerHTML = ''; // Clear previous results

    if (employees.length === 0) {
        container.innerHTML = '<p>No employees found.</p>';
        return;
    }

    employees.forEach(emp => {
        const employeeCard = `
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">${emp.name}</h5>
                        <p class="card-text"><strong>Department:</strong> ${emp.department}</p>
                        <p class="card-text"><strong>Job Title:</strong> ${emp.jobTitle}</p>
                        <p class="card-text"><strong>Phone:</strong> ${emp.phone}</p>
                        <p class="card-text"><strong>Location:</strong> ${emp.location}</p>
                        <p class="card-text"><strong>Years of Service:</strong> ${emp.yearsOfService}</p>
                    </div>
                </div>
            </div>
        `;
        container.innerHTML += employeeCard;
    });
}
