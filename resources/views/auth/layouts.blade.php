<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/front.js'])
    <script src="https://kit.fontawesome.com/d89a21a1ce.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>
<body>
    <main class="min-h-screen flex items-center justify-center bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>