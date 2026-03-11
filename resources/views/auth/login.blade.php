@extends('app')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold">Login</h1>

    @if ($errors->any())
        <div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-700">
            {{ $errors->first() }}
        </div>
    @endif
    <form method="POST" action="{{ route('login.post') }}" class="space-y-4 max-w-md">
        @csrf
        <div>
            <label for="email" class="mb-1 block text-sm font-medium">Email</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required autofocus class="w-full rounded border px-3 py-2"
            >
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium">Password</label>
            <input id="password"
                   type="password"
                   name="password"
                   required class="w-full rounded border px-3 py-2"
            >
        </div>

        <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-white">
            Sign in
        </button>
    </form>

    <p class="mt-4 text-sm">
        Don’t have an account?
        <a href="{{ route('register') }}" class="underline">Create one</a>
    </p>

@endsection
