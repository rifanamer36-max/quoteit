<!<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuoteIt</title>
    <style>[x-cloak]{display:none !important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-center bg-fixed bg-no-repeat"
      style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover;">

    <nav class="relative sticky top-0 z-50 border-b border-white/30 bg-[#10081F] shadow-sm">
        <p class="site-name">QuoteIt</p>
        <ul class="mx-auto flex max-w-7xl items-center gap-6 px-4 py-1">
            @auth
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn-primary">Log Out</button>
                    </form>
                </li>
                <li>
                    <img src="{{ asset('images/profile.jpeg') }}" alt="Profile"
                         class="h-10 w-10 rounded-full object-cover ring-2 ring-tuwaiq-purple">
                </li>
                <li><p class="text-white">{{ auth()->user()->name }}</p></li>
            @else
                <li><a href="{{ route('login') }}" class="btn-primary">Log In</a></li>
                <li><a href="{{ route('register') }}" class="btn-primary">Sign Up</a></li>
            @endauth
            <li class="ml-auto"><img src="{{ asset('images/logo.png') }}" class="h-16 w-auto" alt="Logo"></li>
        </ul>
    </nav>

    <main class="mx-auto max-w-3xl p-8" x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }">

        <h2 class="mb-4 text-2xl font-bold text-white">Quotes</h2>

        @guest
            <a href="{{ route('login') }}" class="btn-primary mb-6">Log in to share a quote</a>
        @endguest

        <div class="space-y-4">
            @forelse ($quotes as $quote)
                @php
                    $mine = auth()->id() === $quote->user_id;
                    $liked = auth()->check() && $quote->likedBy->contains(auth()->id());
                @endphp

                <div class="rounded-2xl p-5 shadow {{ $mine ? 'bg-tuwaiq-purple text-white' : 'bg-white text-tuwaiq-purple' }}"
                     x-data="{ editing: {{ $errors->update->has('text') && old('quote_id') == $quote->id ? 'true' : 'false' }} }">

                    <div x-show="!editing">
                        <p class="text-lg">“{{ $quote->text }}”</p>
                        <p class="mt-2 text-sm">
                            <span class="font-semibold">— {{ $mine ? 'You' : $quote->user->name }}</span>
                            <span class="text-xs opacity-70">· {{ $quote->created_at->format('d M Y') }}</span>
                        </p>

                        <div class="mt-3 flex items-center gap-4 text-sm">
                            @auth
                                <form method="POST" action="{{ route('quotes.like', $quote) }}">
                                    @csrf
                                    <button>{{ $liked ? '❤️' : '🤍' }} {{ $quote->likedBy->count() }}</button>
                                </form>
                            @else
                                <span>🤍 {{ $quote->likedBy->count() }}</span>
                            @endauth

                            @can('update', $quote)
                                <button @click="editing = true" class="hover:text-tuwaiq-orange">✎ Edit</button>
                                <form method="POST" action="{{ route('quotes.destroy', $quote) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="hover:text-tuwaiq-orange">⌫ Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>

                    @can('update', $quote)
                        <form x-show="editing" x-cloak method="POST" action="{{ route('quotes.update', $quote) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="quote_id" value="{{ $quote->id }}">

                            <textarea name="text" rows="3" minlength="3" maxlength="155" required
                                      class="input">{{ old('quote_id') == $quote->id ? old('text') : $quote->text }}</textarea>

                            @if (old('quote_id') == $quote->id)
                                @error('text', 'update')
                                    <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                                @enderror
                            @endif

                            <div class="mt-3 flex gap-3">
                                <button class="btn-secondary">Save</button>
                                <button type="button" @click="editing = false" class="hover:underline">Cancel</button>
                            </div>
                        </form>
                    @endcan
                </div>
            @empty
                <p class="text-gray-300">No quotes yet. Be the first to share one!</p>
            @endforelse
        </div>

        @auth
            <button @click="open = true" aria-label="Share a quote"
                    class="fixed bottom-8 right-8 z-40 flex h-16 w-16 items-center justify-center rounded-full bg-tuwaiq-purple text-4xl text-white shadow-xl transition hover:scale-110 hover:bg-tuwaiq-purple-light">
                +
            </button>

            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                <div class="w-full max-w-lg rounded-3xl bg-white p-6 shadow-2xl">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-tuwaiq-purple">Share a quote</h2>
                        <button @click="open = false" class="text-xl text-gray-400 hover:text-gray-700">✕</button>
                    </div>

                    <form method="POST" action="{{ route('quotes.store') }}" class="space-y-3">
                        @csrf
                        <textarea name="text" rows="5" minlength="3" maxlength="155" required
                                  placeholder="Write your quote…" class="input resize-none">{{ old('text') }}</textarea>
                        <p class="text-xs text-gray-500">3–155 characters.</p>

                        @error('text')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <button class="btn-primary w-full">Send</button>
                    </form>
                </div>
            </div>
        @endauth

    </main>
</body>
</html>