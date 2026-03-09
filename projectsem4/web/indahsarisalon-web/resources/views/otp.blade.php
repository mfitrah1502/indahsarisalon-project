<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masukkan OTP - Indah Sari Salon</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #ffc0cb;
            font-family: Arial;
        }

        .auth-wrapper {
            width: 400px;
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 40px 30px rgba(0, 0, 0, 0.08);
        }

        .btn-custom {
            background: #ea8290;
            color: white;
            border: none;
            width: 100%;
            padding: 12px;
            border-radius: 16px;
            font-weight: bold;
        }

        .btn-custom:hover {
            background: #d9727f;
        }
    </style>

</head>

<body>

    <div class="auth-wrapper">

        <h2 class="text-center mb-3">Masukkan OTP</h2>
        <p class="text-center text-muted mb-4">
            Silahkan masukkan kode OTP yang dikirim ke email Anda.
        </p>
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('otp.verify') }}" method="POST">
            @csrf

            <input type="hidden" name="email" value="{{ request('email') }}">

            <div class="mb-3">
                <label>Kode OTP</label>
                <input type="text" name="otp" class="form-control" required>
            </div>

            <button type="submit" class="btn-custom">
                Verifikasi OTP
            </button>

        </form>

        <p class="text-center mt-3">
            Kembali ke <a href="{{ route('auth') }}">Login</a>
        </p>

    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const otpInput = document.querySelector('input[name="otp"]');

            // Saat submit, cek OTP kosong dulu (atau bisa ditambah logika lain)
            form.addEventListener('submit', function (e) {
                const existingAlert = document.querySelector('.js-alert');
                if (existingAlert) existingAlert.remove();

                if (!otpInput.value.trim()) { // contoh validasi sederhana
                    e.preventDefault(); // cegah submit
                    const alertDiv = document.createElement('div');
                    alertDiv.classList.add('alert', 'alert-danger', 'js-alert');
                    alertDiv.innerText = 'Kode OTP tidak boleh kosong!';
                    form.prepend(alertDiv); // tampilkan di atas form
                }
            });

            // Hilangkan alert saat user klik/fokus di input OTP
            otpInput.addEventListener('focus', function () {
                const existingAlert = document.querySelector('.js-alert');
                if (existingAlert) existingAlert.remove();
            });
        });
    </script>
</body>

</html>