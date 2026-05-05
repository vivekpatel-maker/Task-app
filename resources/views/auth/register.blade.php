<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .error-text {
            color: red;
            font-size: 13px;
            margin-top: 4px;
        }
    </style>
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">

    <div class="card shadow p-4" style="width: 400px; border-radius: 12px;">

        <h3 class="text-center mb-3">Register</h3>

        <form method="POST" action="/register" onsubmit="return validateForm()">
            @csrf

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" id="name" name="name" class="form-control" onkeyup="validateName()">
                <div id="nameError" class="error-text"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" id="email" name="email" class="form-control" onkeyup="validateEmail()">
                <div id="emailError" class="error-text"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" onkeyup="validatePassword()">
                <div id="passwordError" class="error-text"></div>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Register
            </button>
        </form>
        <p class="text-center mt-3 mb-0">
            You have already an account?
            <a href="/login">Login</a>
        </p>

    </div>

</div>

<script>
let nameValid = false;
let emailValid = false;
let passwordValid = false;

function validateName() {
    let name = document.getElementById("name").value;
    let error = document.getElementById("nameError");

    let pattern = /^[A-Za-z\s]+$/;

    if (name.length === 0) {
        error.innerText = "Name is required";
        nameValid = false;
    }
    else if (name.length > 30) {
        error.innerText = "Name must be max 30 characters";
        nameValid = false;
    }
    else if (!pattern.test(name)) {
        error.innerText = "Name should contain only letters (no numbers allowed)";
        nameValid = false;
    }
    else {
        error.innerText = "";
        nameValid = true;
    }
}

function validateEmail() {
    let email = document.getElementById("email").value;
    let error = document.getElementById("emailError");

    let pattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (email.length === 0) {
        error.innerText = "Email is required";
        emailValid = false;
    }
    else if (email.length > 50) {
        error.innerText = "Email must be max 50 characters";
        emailValid = false;
    }
    else if (!pattern.test(email)) {
        error.innerText = "Enter valid email format";
        emailValid = false;
    }
    else {
        error.innerText = "";
        emailValid = true;
    }
}

function validatePassword() {
    let password = document.getElementById("password").value;
    let error = document.getElementById("passwordError");

    if (password.length === 0) {
        error.innerText = "Password is required";
        passwordValid = false;
    }
    else if (password.length < 6) {
        error.innerText = "Minimum 6 characters required";
        passwordValid = false;
    }
    else if (password.length > 12) {
        error.innerText = "Maximum 12 characters allowed";
        passwordValid = false;
    }
    else {
        error.innerText = "";
        passwordValid = true;
    }
}

function validateForm() {
    validateName();
    validateEmail();
    validatePassword();

    return nameValid && emailValid && passwordValid;
}
</script>

</body>
</html>