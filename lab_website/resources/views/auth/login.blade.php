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
    <!-- Login box container -->
    <div class="login-box">
        <h2>Login</h2>

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

            <div class="user-box">
                <input type="email" name="email" id="email" required value="{{ old('email') }}">
                <label for="email">Email</label>
            </div>

            <div class="user-box">
                <input type="password" name="password" id="password" required>
                <label for="password">Password</label>
            </div>

            <!-- Submit Button with Animations -->
            <a href="javascript:void(0);" class="submit-button" onclick="document.querySelector('form').submit();">
                <span></span><span></span><span></span><span></span>Login
            </a>
        </form>

        <p>Don't have an account? <a href="{{ route('register') }}">Register here</a>.</p>
    </div>
</body>
</html>
