{{-- Top bar shared by every page: logos on the right, account links on the left --}}
<nav class="relative sticky top-0 z-50 border-b border-white/30 bg-[#10081F] shadow-sm">
    <ul class="mx-auto flex max-w-7xl flex-wrap items-center gap-3 px-3 py-1 sm:gap-6 sm:px-4">
        @auth
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-primary !px-4 !text-base sm:!px-6 sm:!text-lg">Log Out</button>
                </form>
            </li>
            <li>
                <img src="{{ asset('images/profile.jpeg') }}" alt="Profile"
                     class="h-9 w-9 rounded-full object-cover ring-2 ring-tuwaiq-purple sm:h-10 sm:w-10">
            </li>
            <li><p class="hidden text-white sm:block">{{ auth()->user()->name }}</p></li>
            <li><a href="{{ route('quotes.saved') }}" class="text-white hover:text-tuwaiq-orange">مُدْرَكَاتي</a></li>
            <li><a href="{{ route('quotes.index') }}" class="text-white hover:text-tuwaiq-orange">Home</a></li>
        @else
            @unless (request()->routeIs('login'))
                <li><a href="{{ route('login') }}" class="btn-primary !px-4 !text-base sm:!px-6 sm:!text-lg">Log In</a></li>
            @endunless
            @unless (request()->routeIs('register'))
                <li><a href="{{ route('register') }}" class="btn-primary !px-4 !text-base sm:!px-6 sm:!text-lg">Sign Up</a></li>
            @endunless
        @endauth

        <li class="ml-auto flex items-center gap-2 sm:gap-4">
            <img src="{{ asset('images/edrak-logo.png') }}" class="h-8 w-auto sm:h-12" alt="Edrak">
            <span class="hidden h-10 w-px bg-white/30 sm:block"></span>
            <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto sm:h-16" alt="Tuwaiq">
        </li>
    </ul>
</nav>
