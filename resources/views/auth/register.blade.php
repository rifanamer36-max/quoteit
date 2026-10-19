@extends('layouts.tuwaiq')

@section('title', 'Sign Up')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2">

    <div class="flex items-center justify-center p-8">
        <form method="POST" action="{{ route('register') }}" class="mx-auto mt-5 w-full max-w-xl p-9">
            @csrf
            <h2 class="mb-4 text-center text-2xl font-bold text-white">Sign Up</h2>

            <div class="mb-4">
                <label for="name" class="label">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required minlength="2" maxlength="50"
                       pattern="[A-Za-z\u0600-\u06FF ]+" class="input">
                <p class="mt-1 text-xs text-white">2–50 characters, letters only.</p>
                @error('name')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="label">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="input">
                <p class="mt-1 text-xs text-white">A valid email, e.g. name@example.com</p>
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="label">Password</label>
                <input id="password" name="password" type="password" required minlength="8" class="input">
                <p class="mt-1 text-xs text-white">At least 8 characters.</p>
                @error('password')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <p class="mb-4 text-sm text-white">
                Already have an account? <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Log In</a>
            </p>

            <button class="btn-primary w-full">Sign Up</button>
        </form>
    </div>

    <div class="hidden items-center justify-center md:flex">
        <img src="{{ asset('images/signup.jpeg') }}" alt="QuoteIt" class="w-full max-w-sm rounded-2xl object-contain">
    </div>
</div>
@endsection