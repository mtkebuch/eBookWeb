document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('registrationForm');
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const submitButton = document.getElementById('submitBtn');

    submitButton.addEventListener('click', function (e) {
        
       
        if (!username.value || !email.value || !password.value || !confirmPassword.value) {
            e.preventDefault();  
            alert("All fields must be filled out!");  
            return;
        }

       
        if (password.value !== confirmPassword.value) {
            e.preventDefault(); 
            alert("Passwords do not match!");  
            return;
        }

        
        const strongPasswordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/;
        if (!strongPasswordPattern.test(password.value)) {
            e.preventDefault();
            alert("Password must be at least 6 characters long and include uppercase, lowercase, number, and symbol!");
        }
    });
});

function togglePassword(id) {
    const field = document.getElementById(id);
    const icon = field.nextElementSibling;

    if (field.type === "password") {
        field.type = "text";
        icon.textContent = "☀️";
    } else {
        field.type = "password";
        icon.textContent = "🌑";
    }
}
