<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {!! SEO::generate() !!}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])  
        
</head>
<body class="bg-background font-sans text-slate-800 antialiased min-h-screen flex flex-col">
    <header class="sticky top-0 z-50 w-full">
        @include('components.navbar')
    </header>

    <main class="grow w-full">
        @yield('content')
    </main>

    <footer>
        {{-- @include('components.footer') --}}
    </footer>
</body>
</html>