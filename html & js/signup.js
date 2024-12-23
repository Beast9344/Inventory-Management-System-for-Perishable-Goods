// Function to handle signup form submission
document.getElementById('signupForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent the form from submitting immediately

    // Retrieve input values
    const fullName = document.getElementById('fullName').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirmPassword').value;
    const role = document.getElementById('role').value;
    const errorMessage = document.getElementById('errorMessage');

    // Validation checks
    if (!fullName || !email || !password || !confirmPassword || !role) {
        errorMessage.textContent = "All fields are required.";
        return;
    }

    if (password.length < 6) {
        errorMessage.textContent = "Password must be at least 6 characters.";
        return;
    }

    if (password !== confirmPassword) {
        errorMessage.textContent = "Passwords do not match.";
        return;
    }

    // Clear error message if all validations pass
    errorMessage.textContent = "";

    // Save user data to local storage
    const user = {
        username: fullName,
        email: email,
        password: password,
        role: role
    };
    localStorage.setItem('user', JSON.stringify(user));

    alert("Sign-up successful!");

    // Redirect to login page
    window.location.href = "login.html";
});
