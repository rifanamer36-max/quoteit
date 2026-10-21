@extends('layouts.tuwaiq')

@section('title', 'Log In')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2">

    <div class="flex items-center justify-center p-8">
        <form method="POST" action="{{ route('login') }}" class="mx-auto mt-5 w-full max-w-xl p-9">
            @csrf
            <h2 class="mb-4 text-center text-2xl font-bold text-white">Log In</h2>

            <div class="mb-4">
                <label for="email" class="label">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="input">
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
                Don't have an account? <a href="{{ route('register') }}" class="text-blue-400 hover:underline">Sign Up</a>
            </p>

            <button class="btn-primary w-full">Log In</button>
        </form>
    </div>

   <div class="hidden items-center justify-center p-8 md:flex">
    <div class="w-full max-w-sm rounded-3xl border border-white/20 bg-gradient-to-br from-tuwaiq-purple/60 to-[#10081F]/80 p-8 text-center shadow-[0_0_60px_rgba(147,51,234,0.35)]">
        <img src="{{ asset('images/edrak-logo.png') }}" alt="Edrak" class="mx-auto w-72 max-w-full">
        <p class="mt-6 text-lg text-white/80" dir="rtl">سطورٌ تشرح ما تشعر به</p>
        <p class="mt-2 text-sm text-tuwaiq-orange">Find the words that match how you feel.</p>
    </div>
</div>
@endsection