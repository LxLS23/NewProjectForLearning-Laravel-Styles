<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Views')</title>
    <!--For Include Tailwind-->
    @vite('resources/css/app.css')
</head>

<body>
    <x-navbar/>
    <main class="mt-24 w-full mb-24">
        @yield('content')
    </main>

    <x-footer/>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>
</body>

</html>