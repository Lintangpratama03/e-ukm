<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Signup</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Add SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* General Reset */
        body,
        h2,
        p,
        input,
        button {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #6C63FF, #4ADEDE, #FF6584);
            background-size: 300% 300%;
            animation: gradient-bg 8s infinite;
        }

        /* Gradient Animation */
        @keyframes gradient-bg {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Main Container */
        .main-container {
            width: 100%;
            max-width: 400px;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.15);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
        }

        /* Form Wrapper */
        .form-wrapper {
            overflow: hidden;
            position: relative;
        }

        .form-content {
            display: flex;
            transition: transform 0.6s ease-in-out;
            width: 200%;
        }

        .form {
            width: 50%;
            padding: 30px;
            background: white;
            border-radius: 10px;
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .form.active {
            opacity: 1;
            transform: translateY(0);
        }

        h2 {
            margin-bottom: 10px;
            font-weight: 600;
            color: #333;
            font-size: 24px;
        }

        p {
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 10px 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .input-group .input-icon {
            position: absolute;
            top: 50%;
            left: 10px;
            transform: translateY(-50%);
            font-size: 16px;
            color: #aaa;
        }

        .captcha-group {
            margin-bottom: 20px;
        }

        .captcha-group img {
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .captcha-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }

        .refresh-captcha {
            color: #6C63FF;
            font-size: 13px;
            cursor: pointer;
            display: inline-block;
            margin-top: 5px;
        }

        .refresh-captcha:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-radius: 5px;
            background: linear-gradient(120deg, #6C63FF, #FF6584);
            color: white;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: linear-gradient(120deg, #FF6584, #4ADEDE);
        }

        .switch-text {
            text-align: center;
            font-size: 13px;
            color: #555;
        }

        .switch-text .toggle-form {
            color: #6C63FF;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .switch-text .toggle-form:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            margin: 10px 0;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="form-wrapper">
            <div class="form-content">
                <!-- Login Form -->
                <form class="form login-form active" id="loginForm">
                    <h2>Welcome Back!</h2>
                    <p>Login to your account to continue</p>
                    <div class="input-group">
                        <input type="text" name="username" id="loginUsername" placeholder="Username" required>
                        <span class="input-icon">📧</span>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" id="loginPassword" placeholder="Password" required>
                        <span class="input-icon">🔒</span>
                    </div>
                    <div class="captcha-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="captcha-image">
                                    {!! captcha_img('math') !!}
                                </div>
                                <span class="refresh-captcha" id="refreshLoginCaptcha">Refresh Captcha</span>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="captcha" id="loginCaptcha" placeholder="Enter Captcha"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div id="loginError" class="error-message"></div>
                    <button type="submit" class="btn">Login</button>
                    <p class="switch-text">
                        Don't have an account? <span class="toggle-form">Sign Up</span>
                    </p>
                </form>

                <!-- Signup Form -->
                <form class="form signup-form" id="registerForm">
                    <h2>Create Account</h2>
                    <p>Sign up to explore new opportunities</p>
                    <div class="input-group">
                        <input type="text" name="username" id="registerUsername" placeholder="Username" required>
                        <span class="input-icon">👤</span>
                    </div>
                    <div class="input-group">
                        <input type="text" name="fullName" id="registerFullName" placeholder="Full Name" required>
                        <span class="input-icon">👤</span>
                    </div>
                    <div class="input-group">
                        <input type="email" name="email" id="registerEmail" placeholder="Email" required>
                        <span class="input-icon">📧</span>
                    </div>
                    <div class="input-group">
                        <input type="tel" name="contact" id="registerContact" placeholder="Phone Number" required>
                        <span class="input-icon">📱</span>
                    </div>
                    <div class="input-group">
                        <input type="password" name="password" id="registerPassword" placeholder="Password" required>
                        <span class="input-icon">🔒</span>
                    </div>
                    {{-- <div class="captcha-group">
                        <div class="captcha-image">
                            {!! captcha_img('math') !!}
                        </div>
                        <span class="refresh-captcha" id="refreshRegisterCaptcha">Refresh Captcha</span>
                        <input type="text" name="captcha" id="registerCaptcha" placeholder="Enter Captcha" required>
                    </div> --}}

                    <div id="registerError" class="error-message"></div>
                    <button type="submit" class="btn">Sign Up</button>
                    <p class="switch-text">
                        Already have an account? <span class="toggle-form">Login</span>
                    </p>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = "{{ session('success') }}";
            const errorMessage = "{{ session('error-swal') }}";

            if (successMessage && successMessage !== "") {
                Swal.fire({
                    title: 'Success!',
                    text: successMessage,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            }

            if (errorMessage && errorMessage !== "") {
                Swal.fire({
                    title: 'Error!',
                    text: errorMessage,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
            document.getElementById('refreshLoginCaptcha').addEventListener('click', function() {
                refreshCaptcha('login');
            });

            document.getElementById('refreshRegisterCaptcha').addEventListener('click', function() {
                refreshCaptcha('register');
            });
        });

        function refreshCaptcha(formType) {
            fetch('/reload-captcha')
                .then(response => response.json())
                .then(data => {
                    if (formType === 'login') {
                        document.querySelector('.login-form .captcha-image').innerHTML = data.captcha;
                    } else {
                        // document.querySelector('.signup-form .captcha-image').innerHTML = data.captcha;
                    }
                });
        }
        const toggleButtons = document.querySelectorAll(".toggle-form");
        const formContent = document.querySelector(".form-content");
        const loginForm = document.querySelector(".login-form");
        const signupForm = document.querySelector(".signup-form");

        toggleButtons.forEach(button => {
            button.addEventListener("click", () => {
                loginForm.classList.toggle("active");
                signupForm.classList.toggle("active");
                if (signupForm.classList.contains("active")) {
                    formContent.style.transform = "translateX(-50%)";
                } else {
                    formContent.style.transform = "translateX(0%)";
                }
            });
        });
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const username = document.getElementById('loginUsername').value;
            const password = document.getElementById('loginPassword').value;
            const captcha = document.getElementById('loginCaptcha').value;
            const errorDiv = document.getElementById('loginError');
            errorDiv.textContent = '';
            const formData = new FormData();
            formData.append('username', username);
            formData.append('password', password);
            formData.append('captcha', captcha);
            formData.append('_token', '{{ csrf_token() }}');
            fetch('/login', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                        return null;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data === null) return;

                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Login successful!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            window.location.href = data.redirect || '/dashboard';
                        });
                    } else {
                        refreshCaptcha('login');
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Login failed. Please check your credentials.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    refreshCaptcha('login');

                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred during login. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error('Login error:', error);
                });
        });
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const username = document.getElementById('registerUsername').value;
            const fullName = document.getElementById('registerFullName').value;
            const email = document.getElementById('registerEmail').value;
            const contact = document.getElementById('registerContact').value;
            const password = document.getElementById('registerPassword').value;
            // const captcha = document.getElementById('registerCaptcha').value;
            const errorDiv = document.getElementById('registerError');
            errorDiv.textContent = '';
            const formData = new FormData();
            formData.append('username', username);
            formData.append('fullName', fullName);
            formData.append('email', email);
            formData.append('contact', contact);
            formData.append('password', password);
            // formData.append('captcha', captcha);
            formData.append('_token', '{{ csrf_token() }}');
            fetch('/register', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.redirected) {
                        window.location.href = response.url;
                        return null;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data === null) return;

                    if (data.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: data.message || 'Registration successful! Please login.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            window.location.reload();
                        });
                    } else {
                        refreshCaptcha('register');
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Registration failed. Please check your information.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    refreshCaptcha('register');

                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred during registration. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                    console.error('Registration error:', error);
                });
        });
    </script>
</body>

</html>
