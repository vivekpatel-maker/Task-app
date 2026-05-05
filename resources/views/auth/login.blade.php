<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center" style="height:100vh;">

    <div class="card shadow p-4" style="width: 400px; border-radius: 12px;">

        <h3 class="text-center mb-3">Login</h3>

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="/login" onsubmit="return validateLogin()">
            @csrf

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" id="email" name="email" class="form-control" onkeyup="validateEmail()">
                <div id="emailError" class="text-danger"></div>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" onkeyup="validatePassword()">
                <div id="passwordError" class="text-danger"></div>
            </div>

            <button type="submit" class="btn btn-success w-100">
                Login
            </button>
        </form>

        <p class="text-center mt-3 mb-0">
            Don't have an account?
            <a href="/">Register</a>
        </p>

    </div>

</div>

<script>
    let emailValid = false;
    let passwordValid = false;

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
            error.innerText = "Invalid email format";
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

    function validateLogin() {
        validateEmail();
        validatePassword();

        return emailValid && passwordValid;
    }
</script>
</body>
</html>