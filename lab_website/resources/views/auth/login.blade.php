<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div class="animated-background">
        <div class="particles">
            @for ($i = 0; $i < 30; $i++)
                <div class="particle" style="
                    left: {{ rand(0, 100) }}%;
                    top: {{ rand(0, 100) }}%;
                    animation-delay: -{{ rand(0, 30) }}s;
                "></div>
            @endfor
        </div>
    </div>
    <!-- Login Box -->
    <div class="login-box">
        <h2>Login</h2>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div style="color: red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="user-box">
                <input type="email" name="email" id="email" required>
                <label>Email</label>
            </div>

            <!-- Password -->
            <div class="user-box">
                <input type="password" name="password" id="password" required>
                <label>Password</label>
            </div>

            <!-- Submit Button -->
            <a href="javascript:void(0);" onclick="this.closest('form').submit()">
                Login
                <span></span><span></span><span></span><span></span>
            </a>
        </form>

        <!-- Link to Register -->
        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a>.</p>
    </div>
</body>
</html>