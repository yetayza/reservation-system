<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - BestBKK Reservation</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: #f4f6f8;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            background: white;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .login-card h1 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .login-card p {
            color: #666;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
        }

        .remember label {
            margin: 0;
            font-weight: normal;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #222;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background: #444;
        }

        .error {
            color: #c00;
            font-size: 14px;
            margin-top: 6px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="logo">BestBKK Reservation</div>

        <h1>Login</h1>

        <p>Please login to access the reservation system.</p>

        <form method="POST" action="{{ route('login') }}">

            @csrf

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >

                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                >
            </div>

            <div class="remember">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    value="1"
                >

                <label for="remember">Remember me</label>
            </div>

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</body>
</html>