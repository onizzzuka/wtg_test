<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-100 text-gray-900 antialiased">
<header class="border-b bg-white">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="text-lg font-semibold">
            {{ config('app.name', 'Laravel') }}
        </a>

        @if (Route::has('login'))
            <nav class="flex items-center gap-4 text-sm">
                @auth
                    <a href="{{ url('/chat') }}" class="hover:underline">Chat</a>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="hover:underline">Register</a>
                    @endif
                @endauth </nav>
        @endif </div>
</header>

<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
