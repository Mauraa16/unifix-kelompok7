<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'UNIFIX') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#7e22ce',
                    },
                    fontFamily: {
                        sans: ['Nunito', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 antialiased"> 
    <div id="app" class="min-h-screen flex flex-col">
        
        {{-- HEADER (Sticky) --}}
        {{-- Karena Sticky, dia tidak melayang di atas konten, tapi mendorong konten ke bawah --}}
        <header class="sticky top-0 z-50">
            @auth
                @if(Auth::user()->role == 'admin')
                    @include('admin.header')
                @elseif(Auth::user()->role == 'petugas')
                    @include('petugas.header')
                @else
                    @include('layouts.header')
                @endif
            @else
                @include('layouts.header')
            @endauth
        </header>

        {{-- KONTEN UTAMA --}}
        {{-- Perhatikan: Class flex-grow saja. JANGAN tambahkan pt-20 di sini --}}
        <main class="flex-grow pt-[70px]"> 
            @yield('content')
        </main>

        {{-- FOOTER --}}
        @include('layouts.footer')
    </div>
</body>
</html>