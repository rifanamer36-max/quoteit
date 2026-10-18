<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuoteIt</title>
    <style>[x-cloak]{display:none !important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    <nav class="bg-white shadow">
        <div class="max-w-4xl mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('quotes.index') }}" class="text-xl font-bold">QuoteIt</a>

            <div class="flex items-center gap-4">
                @auth
                    <span class="text-gray-700">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-600 hover:underline">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Log in</a>
                    <a href="{{ route('register') }}" class="hover:underline">Register</a>
                @endauth
            </div>
        </div>
    </nav>

   <main class="max-w-4xl mx-auto px-4 py-8" x-data="{ open: {{ $errors->any() ? 'true' : 'false' }} }">

    @guest
        <a href="{{ route('login') }}"
           class="inline-block mb-6 bg-gray-800 text-white px-4 py-2 rounded">
            Log in to share a quote
        </a>
    @endguest

    <div class="space-y-4">
        @forelse ($quotes as $quote)
           <div class="bg-white rounded-lg shadow p-5"
     x-data="{ editing: {{ $errors->update->has('text') && old('quote_id') == $quote->id ? 'true' : 'false' }} }">

    {{-- عرض الاقتباس --}}
    <div x-show="!editing">
        <p class="text-lg">“{{ $quote->text }}”</p>
        <p class="text-sm text-gray-500 mt-3">
            {{ $quote->user->name }} · {{ $quote->created_at->format('d M Y') }}
        </p>
        @php $liked = auth()->check() && $quote->likedBy->contains(auth()->id()); @endphp

<div class="mt-3 text-sm">
    @auth
        <form method="POST" action="{{ route('quotes.like', $quote) }}">
            @csrf
            <button class="{{ $liked ? 'text-red-600' : 'text-gray-500' }}">
                {{ $liked ? '❤️' : '🤍' }} {{ $quote->likedBy->count() }}
            </button>
        </form>
    @else
        <span class="text-gray-500">🤍 {{ $quote->likedBy->count() }}</span>
    @endauth
</div>

        @can('update', $quote)
            <div class="flex gap-4 mt-3 text-sm">
                <button @click="editing = true" class="text-blue-600 hover:underline">Edit</button>

                <form method="POST" action="{{ route('quotes.destroy', $quote) }}">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:underline">Delete</button>
                </form>
            </div>
        @endcan
    </div>

    {{-- نموذج التعديل --}}
    @can('update', $quote)
        <form x-show="editing" x-cloak method="POST"
              action="{{ route('quotes.update', $quote) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="quote_id" value="{{ $quote->id }}">

            <textarea name="text" rows="3" maxlength="155"
                      class="w-full border rounded p-2">{{ old('quote_id') == $quote->id ? old('text') : $quote->text }}</textarea>

            @if (old('quote_id') == $quote->id)
                @error('text', 'update')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            @endif

            <div class="flex gap-3 mt-3">
                <button class="bg-gray-800 text-white px-4 py-1 rounded">Save</button>
                <button type="button" @click="editing = false"
                        class="text-gray-600 hover:underline">Cancel</button>
            </div>
        </form>
    @endcan
</div>
        @empty
            <p class="text-gray-500">No quotes yet.</p>
        @endforelse
    </div>

    @auth
        {{-- زر + --}}
        <button @click="open = true"
                class="fixed bottom-6 right-6 bg-gray-800 text-white w-14 h-14 rounded-full text-3xl shadow-lg">
            +
        </button>

        {{-- نافذة Share a quote --}}
        <div x-show="open" x-cloak
             class="fixed inset-0 bg-black/50 flex items-center justify-center p-4">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-bold">Share a quote</h2>
                    <button @click="open = false" class="text-gray-500 text-xl">✕</button>
                </div>

                <form method="POST" action="{{ route('quotes.store') }}">
                    @csrf
                    <textarea name="text" rows="4" maxlength="155"
                              placeholder="3 to 155 characters"
                              class="w-full border rounded p-2">{{ old('text') }}</textarea>

                    @error('text')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror

                    <button class="mt-4 bg-gray-800 text-white px-4 py-2 rounded">Send</button>
                </form>
            </div>
        </div>
    @endauth

</main>
</body>
</html>