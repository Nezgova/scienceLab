<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Link to the CSS file -->
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Registration Box -->
    <div class="login-box">
        <h2>Register</h2>

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

        <!-- Registration Form -->
        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <!-- Email -->
            <div class="user-box">
                <input type="email" name="email" id="email" required value="{{ old('email') }}">
                <label for="email">Email:</label>
            </div>

            <!-- Password -->
            <div class="user-box">
                <input type="password" name="password" id="password" required>
                <label for="password">Password:</label>
            </div>

            <!-- Confirm Password -->
            <div class="user-box">
                <input type="password" name="password_confirmation" id="password_confirmation" required>
                <label for="password_confirmation">Confirm Password:</label>
            </div>

            <!-- Submit Button -->
            <a href="javascript:void(0);" onclick="this.closest('form').submit()">
                Register
                <span></span><span></span><span></span><span></span>
            </a>
        </form>

        <!-- Link to Login -->
        <p>Already have an account? <a href="{{ route('login') }}">Login here</a>.</p>
    </div>
</body>
</html>
