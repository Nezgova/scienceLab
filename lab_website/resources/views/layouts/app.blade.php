<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="{{ asset('css/home.css') }}" rel="stylesheet">  <!-- Home CSS -->
        <link href="{{ asset('css/navbar.css') }}" rel="stylesheet"> 
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<!-- Navbar CSS -->
        @yield('styles') <!-- profile.css or other styles will load here -->

        <title>@yield('title', 'Home')</title>
        
        <!-- CSRF Token for AJAX requests -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    
    <body>
        <!-- Include the Navbar Component -->
        <x-navbar />

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>

        <!-- Scripts Section -->
        <script src="{{ asset('js/app.js') }}" defer></script> <!-- Default JS -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="{{ asset('/lab_website/resources/js/navbar.js') }}" defer></script>
        @yield('scripts') <!-- JavaScript from child views will load here -->
    </body>
</html>
