@extends('layout.mainlayout')
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
            crossorigin="anonymous"
        />
        <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin-top: 50px;
        }

        .login-form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-form img {
            width: 100%;
            max-width: 300px;
            margin: 0 auto 20px;
            display: block;
            border-radius: 10px;
        }

        .login-form h3 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .password-container {
            position: relative;
        }

        .password-container input {
            padding-right: 40px;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 75%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
        }

        .login-form button[type="submit"] {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background-color: #4caf50;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-form button[type="submit"]:hover {
            background-color: #45a049;
        }

        .login-form label {
            font-weight: bold;
            margin-top: 10px;
            color: #555;
        }

        .login-form p {
            text-align: center;
            margin-top: 20px;
            color: #888;
        }

        .login-form p a {
            color: #4caf50;
            text-decoration: none;
        }

        .login-form p a:hover {
            text-decoration: underline;
        }
        .spinner {
    display: none; /* Sembunyikan spinner secara default */
    margin-left: 5px; /* Beri jarak antara teks dan spinner */
}
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-form">
            <img src="inklusii.jpg" alt="Admin Login">
            <h3>Login Admin</h3>

            @if($errors->any())
                <div class="alert alert-danger">{{ $errors->first('loginError') }}</div>
            @endif

            <form action="{{ url('/login') }}" method="post" >
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Username:</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Masukkan Username Anda">
                </div>
                <div class="mb-3 password-container">
                    <label for="password" class="form-label">Password:</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan Password Anda">
                    <span class="toggle-password">
                        <i class="fas fa-eye-slash" id="togglePassword"></i>
                    </span>
                </div>
                <div class="d-grid">
                <button type="submit" class="btn btn-primary" id="loginButton" style="background-color:#ABCCFE; border:none; color:black;">
                    <span id="loginText">Login</span>
                    <span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
                </div>
            </form>
        </div>
    </div>


        <script>
            const togglePassword = document.querySelector('#togglePassword');
            const password = document.querySelector('#password');

            togglePassword.addEventListener('click', function () {
                // Toggle the type attribute between password and text
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);

                // Toggle the eye icon
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
            document.addEventListener('DOMContentLoaded', function() {
    			var submitBtn = document.getElementById('loginButton');
			    var spinner = document.getElementById('spinner');
    			var btnText = document.getElementById('loginText');

			    submitBtn.addEventListener('click', function() {
        			// Show the spinner
			        spinner.classList.remove('d-none');
        			btnText.classList.add('d-none');

    			    // Optionally, disable the button to prevent multiple submissions
    			    submitBtn.classList.add('btn-loading');
    			});
			});
        </script>
    </body>
</html>