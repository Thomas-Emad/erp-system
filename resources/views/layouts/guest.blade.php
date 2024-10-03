<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="snap-y scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/image/icons/icon.png') }}" type="image/x-icon">
    <meta name="description"
        content="Welcome to my profile, my name is Thomas Emad. I'm a Backend Developer PHP, And I Love programming and Technology">
    <title>Thomas Emad || @yield('title')</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-purple-900">
    <!-- Loader -->
    <div class="loader bg-gray-900 fixed top-0 left-0 w-full h-full z-[52]">
        <svg width="200" height="100" viewBox="0 0 350 200">
            <path class="lt" d="M 100 50 L 50 100 L 100 150"></path>
            <path class="slash" d="M 150 175 L 200 25"></path>
            <path class="gt" d="M 250 50 L 300 100 L 250 150"></path>
        </svg>
    </div>

    <main class="bg-gray-100 min-h-screen">
        @yield('content')
    </main>

    <script src="{{ asset('assets/js/jquery.js') }}"></script>
    <script>
        window.addEventListener("load", function() {
            document.getElementsByClassName("loader")[0].style.display = "none";
        })
    </script>

</body>

</html>