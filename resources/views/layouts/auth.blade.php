<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com?plugins=container-queries"></script>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">

    <!-- Custom Auth CSS via Vite -->
    @vite(['resources/css/auth.css'])

    <title>@yield('title', 'UNIFIX')</title>
</head>
<body class="antialiased">

    @yield('content')

</body>
</html>