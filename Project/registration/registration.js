document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('form');
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const submitButton = document.querySelector('button[type="submit"]');

    
    submitButton.disabled = true;

    
    form.addEventListener('input', function () {
        if (username.value && email.value && password.value && confirmPassword.value) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    });

    
    form.addEventListener('submit', function (e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault();  
            alert("Passwords do not match!");
        }
    });
});
