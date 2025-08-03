<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/d89a21a1ce.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('styles')
</head>

<body class="bg-blue-100 text-gray-800 font-sans relative">
    <!-- Header -->
    @include('complaints.layouts.header')
    
    @yield('content')
    
    <!-- FOOTER -->
    @include('complaints.layouts.footer')

</body>

@stack('scripts')
</html>