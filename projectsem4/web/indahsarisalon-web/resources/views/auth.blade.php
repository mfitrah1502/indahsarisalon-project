<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indah Sari Salon</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            font-family: Arial, sans-serif;
        }

        .left-panel {
            flex: 1;
            background: #ffffff;
        }

        .right-panel {
            flex: 1;
            background: #ffc0cb;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-right: 120px;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 600px;
            height: 900px;
            overflow: hidden;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 40px 30px rgba(0, 0, 0, 0.08);

            align-items: center;
            justify-content: center;
        }

        .auth-container {
            display: flex;
            width: 200%;
            height: 100%;
            transition: transform 0.6s ease-in-out;
            align-items: center;
        }

        .auth-form {
            width: 50%;
            padding: 40px;
        }

        .slide-register {
            transform: translateX(-50%);
        }

        /* ===== CUSTOM BUTTON ===== */
        .auth-wrapper .auth-form button.btn-custom,
        .auth-wrapper .auth-form button.btn-custom:focus,
        .auth-wrapper .auth-form button.btn-custom:active {
            background-color: #ea8290 !important;
            color: white !important;
            border-radius: 16px !important;
            width: 100% !important;
            border: none !important;
            padding: 12px !important;
            font-weight: bold !important;
            font-size: 16px !important;
        }

        .auth-wrapper .auth-form button.btn-custom:hover {
            background-color: #ea8290 !important;
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .left-panel {
                display: none;
            }

            .right-panel {
                justify-content: center;
                padding: 20px;
            }

            .auth-wrapper {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>

    <div class="left-panel"></div>

    <div class="right-panel">

        <div class="auth-wrapper">
            <div class="auth-container {{ session('showRegister') || $errors->any() ? 'slide-register' : '' }}">

                <!-- ================= LOGIN ================= -->
                <div class="auth-form">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/images/indahsarisalonimg.jpg') }}" alt="Logo" class="logo-circle">
                    </div>
                    <h2 class="text-center mb-2">Login</h2>
                    <p class="text-center text-muted mb-4">Silahkan login terlebih dahulu.</p>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="loginForm" action="{{ route('login.process') }}" method="POST">
                        @csrf
                        <div id="loginAlert"></div>

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username"
                                class="form-control @error('username') is-invalid @enderror"
                                value="{{ old('username') }}">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <p class="text-end mt-1 mb-3">
                            <a href="{{ route('reset.password') }}" class="text-decoration-none">Lupa Password?</a>
                        </p>

                        <button type="submit" class="btn-custom">
                            Login
                        </button>
                    </form>

                    <p class=" text-center mt-3">
                        Belum punya akun?
                        <a href="#" id="showRegister">Daftar</a>
                    </p>
                </div>

                <!-- ================= REGISTER ================= -->
                <div class="auth-form">
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/images/indahsarisalonimg.jpg') }}" alt="Logo" class="logo-circle">
                    </div>
                    <h2 class="text-center mb-2">Register</h2>
                    <p class="text-center text-muted mb-4">Silahkan buat akun baru.</p>

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="registerForm" action="{{ route('register.process') }}" method="POST">
                        @csrf
                        <div id="registerAlert"></div>

                        <div class="mb-3">
                            <label>Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" value="{{ old('username') }}"
                                class="form-control @error('username') is-invalid @enderror">
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn-custom">
                            Register
                        </button>
                    </form>

                    <p class="text-center mt-3">
                        Sudah punya akun?
                        <a href="#" id="showLogin">Login</a>
                    </p>
                </div>

            </div>
        </div>

    </div>

    <!-- SCRIPT SLIDE -->
    <script>
        const container = document.querySelector('.auth-container');
        const loginForm = document.getElementById('loginForm');
        const loginAlert = document.getElementById('loginAlert');
        const showRegister = document.getElementById('showRegister');
        const showLogin = document.getElementById('showLogin');
        if (showRegister) {
            showRegister.addEventListener('click', function (e) {
                e.preventDefault();
                container.classList.add('slide-register');
            });
        }

        if (showLogin) {
            showLogin.addEventListener('click', function (e) {
                e.preventDefault();
                container.classList.remove('slide-register');
            });
        }

        function clearLoginAlert() {
            loginAlert.innerHTML = '';
        }

        if (loginForm) {
            loginForm.addEventListener('submit', function (e) {
                const username = loginForm.querySelector('input[name="username"]').value.trim();
                const password = loginForm.querySelector('input[name="password"]').value.trim();

                clearLoginAlert();

                if (!username || !password) {
                    e.preventDefault();
                    loginAlert.innerHTML = `
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>Peringatan!</strong> Semua kolom wajib diisi.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
                }
            });

            loginForm.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', clearLoginAlert);
            });
        }

        // ===== REGISTER FORM =====
        const registerForm = document.getElementById('registerForm');
        const registerAlert = document.getElementById('registerAlert');

        function clearRegisterAlert() {
            registerAlert.innerHTML = '';
        }

        if (registerForm) {
            registerForm.addEventListener('submit', function (e) {
                const username = registerForm.querySelector('input[name="username"]').value.trim();
                const email = registerForm.querySelector('input[name="email"]').value.trim();
                const password = registerForm.querySelector('input[name="password"]').value.trim();
                const passwordConfirm = registerForm.querySelector('input[name="password_confirmation"]').value.trim();

                clearRegisterAlert();

                if (!username || !email || !password || !passwordConfirm) {
                    e.preventDefault();
                    registerAlert.innerHTML = `
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>Peringatan!</strong> Semua kolom wajib diisi.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                } else if (password !== passwordConfirm) {
                    e.preventDefault();
                    registerAlert.innerHTML = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Peringatan!</strong> Password dan konfirmasi password tidak cocok.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                }
            });

            registerForm.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', clearRegisterAlert);
            });
        }

        // ===== CLEAR ALERT WHEN SWITCH SLIDE =====
        if (showRegister) {
            showRegister.addEventListener('click', clearLoginAlert);
        }
        if (showLogin) {
            showLogin.addEventListener('click', clearRegisterAlert);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>