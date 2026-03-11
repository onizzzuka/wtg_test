<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-screen overflow-hidden bg-gray-100 text-gray-900 antialiased flex flex-col">
<header class="border-b bg-white">
    <div class="mx-auto flex items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
        <a href="{{ url('/') }}" class="text-lg font-semibold">
            {{ config('app.name', 'Laravel') }}
        </a>

        <nav class="flex items-center gap-4 text-sm leading-none">
            @auth
                <span class="flex h-6 items-center">{{ $me->name }}</span>

                <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center m-0">
                    @csrf
                    <button type="submit" class="inline-flex items-center hover:underline relative top-px">Logout</button>
                </form>
            @endauth
        </nav>
    </div>
</header>

<main class="mx-auto px-4 py-8 sm:px-6 lg:px-8 flex-1 min-h-0 w-full">
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
