@extends('app')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold">Register</h1>

    @if ($errors->any())
        <div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-700">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}" class="space-y-4 max-w-md">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required
                   class="w-full rounded border px-3 py-2">
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                   class="w-full rounded border px-3 py-2">
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium">Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full rounded border px-3 py-2">
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full rounded border px-3 py-2">
        </div>

        <button type="submit" class="rounded bg-gray-900 px-4 py-2 text-white">
            Create account
        </button>
    </form>

    <p class="mt-4 text-sm">
        Already have an account?
        <a href="{{ route('login') }}" class="underline">Sign in</a>
    </p>
@endsection
