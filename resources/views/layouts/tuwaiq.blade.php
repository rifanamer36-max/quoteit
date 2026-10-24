<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'إدراك')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-center bg-fixed bg-no-repeat"
      style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover;">

   <nav class="relative sticky top-0 z-50 border-b border-white/30 bg-[#10081F] shadow-sm">
    <ul class="mx-auto flex max-w-7xl flex-wrap items-center gap-3 px-3 py-1 sm:gap-6 sm:px-4">
        @if (request()->routeIs('login'))
            <li><a href="{{ route('register') }}" class="btn-primary !px-4 !text-base sm:!px-6 sm:!text-lg">Sign Up</a></li>
        @elseif (request()->routeIs('register'))
            <li><a href="{{ route('login') }}" class="btn-primary !px-4 !text-base sm:!px-6 sm:!text-lg">Log In</a></li>
        @endif
        <li class="ml-auto flex items-center gap-2 sm:gap-4">
            <img src="{{ asset('images/edrak-logo.png') }}" class="h-8 w-auto sm:h-12" alt="Edrak">
            <span class="hidden h-10 w-px bg-white/30 sm:block"></span>
            <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto sm:h-16" alt="Tuwaiq">
        </li>
    </ul>
</nav>

    <main>@yield('content')</main>
</body>
</html>