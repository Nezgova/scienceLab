<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">  <!-- Home CSS -->
        <link href="{{ asset('css/navbar.css') }}" rel="stylesheet"> <!-- Navbar CSS -->
        @yield('styles') <!-- profile.css will load here -->
        
        <title>@yield('title', 'Home')</title>
    </head>
    
<body>
    <!-- Include the Navbar Component -->
    <x-navbar />
    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>
</body>
</html>
