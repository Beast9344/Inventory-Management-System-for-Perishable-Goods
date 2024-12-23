
// Function to handle login submission 
function handleLogin(event) {
    event.preventDefault();

    // Get input values
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const role = document.getElementById('role').value;
    const errorMessage = document.getElementById('error-message');

    // Retrieve user data from local storage
    const storedUser = JSON.parse(localStorage.getItem('user'));

    // Check if stored credentials match entered values
    if (storedUser && username === storedUser.username && password === storedUser.password && role === storedUser.role) {
        // Redirect based on the role
        switch (role) {
            case 'admin':
                window.location.href = "dashboard.html";
                break;
            case 'editor_Sales':
                window.location.href = "U_Sales_Officer.html";
                break;
            case 'editor_Product':
                window.location.href = "U_Product_Officer.html";
                break;
            case 'editor_Warehouse':
                window.location.href = "U_Warehouse_Manager.html";
                break;
            default:
                errorMessage.textContent = "Role not recognized.";
                errorMessage.style.color = "red";
                break;
        }
    } else {
        // Show error message if credentials don't match
        errorMessage.textContent = "Invalid username, password, or role.";
        errorMessage.style.color = "red";
    }
}

// Attach the function to form submission
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("login-form").addEventListener("submit", handleLogin);
});
