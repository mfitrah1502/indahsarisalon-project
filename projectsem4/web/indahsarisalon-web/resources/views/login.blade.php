<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body
    style="font-family: 'Arial Regular', Arial, sans-serif; margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: #f5f6fa;">
    <div
        style="width: 100%; max-width: 400px; background: #fff; border: 1px solid #e5e7eb; border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); padding: 24px;">
        <h1 style="margin: 0 0 8px; text-align: center;">Login</h1>
        <p style="margin: 0 0 20px; text-align: center; color: #4b5563;">Silahkan login terlebih dahulu.</p>


        @if (session('error'))
            <div
                style="margin-bottom: 14px; padding: 10px 12px; border-radius: 10px; background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b;">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; margin-bottom: 14px;">
                <label for="username" style="margin-bottom: 6px; font-weight: bold;">Username</label>
                <input type="text" id="username" name="username" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 10px;">
            </div>
            <div style="display: flex; flex-direction: column; margin-bottom: 18px;">
                <label for="password" style="margin-bottom: 6px; font-weight: bold;">Password</label>
                <input type="password" id="password" name="password" required
                    style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 10px;">
            </div>
            <button type="submit"
                style="width: 100%; background: #2563eb; color: #fff; border: none; border-radius: 10px; padding: 10px 12px; font-weight: bold; cursor: pointer;">
                Login
            </button>
        </form>
    </div>
</body>

</html>