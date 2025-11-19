<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SPADA</title>

    <!-- Font + Icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1e3c72, #2a5298, #4e73df);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: white;
            padding: 40px 35px;
            border-radius: 18px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
            animation: slideUp 0.6s ease;
            position: relative;
            overflow: hidden;
        }

        .bubble1,
        .bubble2 {
            position: absolute;
            background: rgba(42, 82, 152, 0.15);
            border-radius: 50%;
        }

        .bubble1 {
            width: 130px;
            height: 130px;
            top: -40px;
            right: -40px;
        }

        .bubble2 {
            width: 100px;
            height: 100px;
            bottom: -30px;
            left: -30px;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 18px;
        }

        .logo img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .title {
            text-align: center;
            font-size: 2rem;
            font-weight: 800;
            color: #2a5298;
        }

        .subtitle {
            text-align: center;
            margin-top: 5px;
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 30px;
        }

        label {
            font-weight: 600;
            color: #2a5298;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ccc;
            margin-top: 6px;
        }

        input:focus {
            border-color: #2a5298;
            outline: none;
            box-shadow: 0 0 5px rgba(42, 82, 152, 0.3);
        }

        .btn-login {
            width: 100%;
            margin-top: 25px;
            padding: 12px;
            background: #2a5298;
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .btn-login:hover {
            background: #1e3c72;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>

    <div class="login-container">

        <div class="bubble1"></div>
        <div class="bubble2"></div>

        <!-- Logo -->
        <div class="logo">
            <img src="{{ asset('logo.png') }}" alt="Logo SPADA">
        </div>

        <!-- Title -->
        <div class="title">Login SPADA</div>
        <div class="subtitle">Masuk untuk melanjutkan pembelajaran</div>

        <!-- Status Session -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Form Login -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mt-4">
                <label for="email">Email</label>
                <x-text-input id="email" type="email" name="email" required autofocus autocomplete="username"
                    class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password">Password</label>
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block mt-1 w-full" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Button -->
            <button class="btn-login">Masuk</button>

        </form>
    </div>

</body>

</html>
