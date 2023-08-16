document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("loginForm");

    function validateEmail(email) {
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailPattern.test(email);
    }

    function validateUserName(userName) {
        return userName.trim().length > 5;
    }

    function validatePassword(password) {
        // You can add custom password validation here if needed
        return password.trim().length > 8;
    }

    function updateInputValidation(inputElement, isValid, errorMessage) {
        const messageElement = inputElement.nextElementSibling;
        if (isValid) {
            inputElement.style.border = "2px solid green";
            messageElement.textContent = "";
        } else {
            inputElement.style.border = "2px solid red";
            messageElement.textContent = errorMessage;
        }
    }

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const email = document.getElementById("email").value;
        const userName = document.getElementById("userName").value;
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        const isEmailValid = validateEmail(email);
        const isUserNameValid = validateUserName(userName);
        const isPasswordValid = validatePassword(password);

        updateInputValidation(document.getElementById("email"), isEmailValid, "Invalid email address");
        updateInputValidation(document.getElementById("userName"), isUserNameValid, "Username must be at least 6 characters long");
        updateInputValidation(document.getElementById("password"), isPasswordValid, "Password must be at least 9 characters long");
        updateInputValidation(document.getElementById("confirmPassword"), isPasswordValid && password === confirmPassword, "Passwords do not match");

        if (isEmailValid && isUserNameValid && isPasswordValid && password === confirmPassword) {
            alert("Form submitted successfully!");
            form.reset();
        }
    });

    const emailInput = document.getElementById("email");
    const userNameInput = document.getElementById("userName");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById("confirmPassword");

    emailInput.addEventListener("input", function() {
        updateInputValidation(this, validateEmail(this.value), "Invalid email address");
    });

    userNameInput.addEventListener("input", function() {
        updateInputValidation(this, validateUserName(this.value), "Username must be at least 6 characters long");
    });

    passwordInput.addEventListener("input", function() {
        updateInputValidation(this, validatePassword(this.value), "Password must be at least 9 characters long");
    });

    confirmPasswordInput.addEventListener("input", function() {
        updateInputValidation(this, validatePassword(this.value) && this.value === passwordInput.value, "Passwords do not match");
    });
});