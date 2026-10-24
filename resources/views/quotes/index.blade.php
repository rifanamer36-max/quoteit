<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إدراك!</title>
    <style>[x-cloak]{display:none !important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-center bg-fixed bg-no-repeat"
      style="background-image: url('{{ asset('images/background.png') }}'); background-size: cover;">

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
            <li><a href="{{ route('login') }}" class="btn-primary !px-4 !text-base sm:!px-6 sm:!text-lg">Log In</a></li>
            <li><a href="{{ route('register') }}" class="btn-primary !px-4 !text-base sm:!px-6 sm:!text-lg">Sign Up</a></li>
        @endauth
        <ul class="ml-auto flex items-center gap-2 sm:gap-4">
            <img src="{{ asset('images/edrak-logo.png') }}" class="h-8 w-auto sm:h-12" alt="Edrak">
            <span class="hidden h-10 w-px bg-white/30 sm:block"></span>
            <img src="{{ asset('images/logo.png') }}" class="h-10 w-auto sm:h-16" alt="Tuwaiq">
</ul>
    </ul>
</nav>

    <main class="mx-auto max-w-3xl p-4 pb-28 sm:p-8 sm:pb-28" x-data="quotesPage({{ $errors->any() ? 'true' : 'false' }})">
@if ($daily)
    <div class="mb-8 rounded-3xl border border-tuwaiq-orange/40 bg-gradient-to-br from-tuwaiq-purple to-[#1a0b3b] p-6 text-white shadow-xl"
         x-data="{ copied: false }">
        <p class="text-sm font-semibold text-tuwaiq-orange">✦ Insight of the Day · إدراك اليوم</p>
        <p class="mt-3 text-2xl leading-relaxed">“{{ $daily->text }}”</p>
        <p class="mt-3 text-sm opacity-80">— {{ $daily->user->name }}</p>
        <button type="button" class="btn-secondary mt-4"
                @click="navigator.clipboard.writeText(@js($daily->text)); copied = true; setTimeout(() => copied = false, 2000)">
            <span x-show="!copied">Copy</span>
            <span x-show="copied" x-cloak>Copied ✓</span>
        </button>
    </div>
@endif
@php
    $focusItems = $quotes->map(fn ($q) => ['text' => $q->text, 'author' => $q->user->name])->values();
@endphp

<div class="mb-8 flex flex-col items-center justify-between gap-3 rounded-2xl border border-white/20 bg-white/5 p-5 text-white sm:flex-row">
    <div>
        <p class="font-semibold">Need a moment of calm?</p>
        <p class="text-sm opacity-70" dir="rtl">تحتاج لحظة صفاء ذهني؟</p>
    </div>
    <button type="button" class="btn-secondary" @click="startFocus(@js($focusItems))">
        Start a calm session ☕
    </button>
</div>
        <h2 class="mb-4 text-2xl font-bold text-white">{{ $title ?? 'Quotes' }} </h2>
<div class="relative mb-4">
    <input type="search" x-model="search" placeholder="Search quotes or authors… ابحث في الاقتباسات"
           class="input pl-10">
    <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2">🔍</span>
</div>
        {{-- Mood compass --}}
        <div class="mb-6 flex flex-wrap gap-2">
            <button type="button" @click="mood = ''"
                    :class="mood === '' ? 'bg-tuwaiq-orange text-tuwaiq-purple' : 'bg-white/10 text-white'"
                    class="rounded-full px-4 py-2 text-sm font-medium transition">All</button>

            @foreach (\App\Models\Quote::MOODS as $key => $label)
                <button type="button" @click="mood = '{{ $key }}'"
                        :class="mood === '{{ $key }}' ? 'bg-tuwaiq-orange text-tuwaiq-purple' : 'bg-white/10 text-white'"
                        class="rounded-full px-4 py-2 text-sm font-medium transition">{{ $label }}</button>
            @endforeach
        </div>

        @guest
            <a href="{{ route('login') }}" class="btn-primary mb-6">Log in to share a quote</a>
        @endguest

        <div class="flex flex-col gap-4">
            @forelse ($quotes as $quote)
                @php
                    $mine = auth()->id() === $quote->user_id;
                    $liked = auth()->check() && $quote->likedBy->contains(auth()->id());
                       $saved = auth()->check() && $quote->savedBy->contains(auth()->id());
                @endphp

               <div class="fade-up rounded-2xl p-5 shadow {{ $mine ? 'bg-tuwaiq-purple text-white' : 'bg-white text-tuwaiq-purple' }}"
     style="animation-delay: {{ min($loop->index, 8) * 60 }}ms"
    x-show="(mood === '' || mood === '{{ $quote->mood }}') && (search === '' || @js(mb_strtolower($quote->text . ' ' . $quote->user->name)).includes(search.toLowerCase().trim()))"
     x-transition.opacity.duration.300ms
     x-data="{ editing: {{ $errors->update->any() && old('quote_id') == $quote->id ? 'true' : 'false' }} }">

                    <div x-show="!editing">
                        <p class="text-lg">“{{ $quote->text }}”</p>
                        <p class="mt-2 text-sm">
                            <span class="font-semibold">— {{ $mine ? 'You' : $quote->user->name }}</span>
                            <span class="text-xs opacity-70">· {{ $quote->created_at->format('d M Y') }}</span>
                        </p>

                        @if ($quote->mood)
                            <span class="mt-2 inline-block rounded-full bg-tuwaiq-orange/20 px-3 py-1 text-xs">
                                {{ \App\Models\Quote::MOODS[$quote->mood] ?? '' }}
                            </span>
                        @endif

                        <div class="mt-3 flex items-center gap-4 text-sm">
                            @auth
                                <form method="POST" action="{{ route('quotes.like', $quote) }}">
                                    @csrf
                                    <button>{{ $liked ? '❤️' : '🤍' }} {{ $quote->likedBy->count() }}</button>
                                </form>
                            @else
                                <span>🤍 {{ $quote->likedBy->count() }}</span>
                            @endauth
                               @auth
       <form method="POST" action="{{ route('quotes.save', $quote) }}">
           @csrf
           <button title="Save to My Insights">{{ $saved ? '🔖 Saved' : '📑 Save' }}</button>
       </form>
   @endauth
<button type="button" @click="openCard(@js($quote->text), @js($quote->user->name))"
        class="hover:text-tuwaiq-orange">🖼 Card</button>
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
                            @php $currentMood = old('quote_id') == $quote->id ? old('mood', $quote->mood) : $quote->mood; @endphp
<select name="mood" required class="input mt-2">
    <option value="" disabled {{ $currentMood ? '' : 'selected' }}>Choose a mood</option>
    @foreach (\App\Models\Quote::MOODS as $key => $label)
        <option value="{{ $key }}" {{ $currentMood === $key ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select>
@if (old('quote_id') == $quote->id)
    @error('mood', 'update')
        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
    @enderror
@endif
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
                <p class="text-gray-300">{{ isset($title) ? "You haven't saved any insights yet." : 'No quotes yet. Be the first to share one!' }}</p>
            @endforelse
        </div>
        </div>

        @auth
            <button @click="open = true" aria-label="Share a quote"
                    class="fixed bottom-8 right-8 z-40 flex h-16 w-16 items-center justify-center rounded-full bg-tuwaiq-purple text-4xl text-white shadow-xl transition hover:scale-110 hover:bg-tuwaiq-purple-light">
                +
            </button>

            <div x-show="open" x-cloak x-transition.opacity.duration.250ms  class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
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

                        <select name="mood" required class="input">
                            <option value="" disabled {{ old('mood') ? '' : 'selected' }}>How does it feel?</option>
                            @foreach (\App\Models\Quote::MOODS as $key => $label)
                                <option value="{{ $key }}" {{ old('mood') === $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('mood')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        <button class="btn-primary w-full">Send</button>
                    </form>
                </div>
            </div>
        @endauth
<div x-show="card.open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 p-4">
    <div class="w-full max-w-md rounded-3xl bg-white p-5 shadow-2xl max-h-[90vh] overflow-y-auto">
        <div class="mb-3 flex items-center justify-between">
            <h2 class="text-xl font-bold text-tuwaiq-purple">Quote card</h2>
            <button @click="card.open = false" class="text-xl text-gray-400 hover:text-gray-700">✕</button>
        </div>

        {{-- The card that becomes an image --}}
        <div x-ref="cardPreview" class="flex fade-up aspect-square w-full flex-col justify-between rounded-2xl p-8"
             :style="`background:${card.bg}; color:${card.fg}; font-family:${card.font}`">
            <span class="text-5xl font-black" style="color:#a020f0; text-shadow:0 0 18px #a020f0">!</span>
            <p class="text-2xl leading-relaxed" x-text="'“' + card.text + '”'"></p>
           <div>
    <div class="flex items-end justify-between">
        <span class="text-sm opacity-80" x-text="'— ' + card.author"></span>
        <span class="text-lg font-bold">إدراك<span style="color:#8b6fd6">!</span></span>
    </div>
    <div x-show="card.stamp" class="mt-3 flex items-center justify-between border-t pt-3"
         :style="`border-color:${card.fg}33`">
        <span class="text-xs opacity-70" dir="rtl">سطورٌ تشرح ما تشعر به</span>
        <img x-show="card.qr" :src="card.qr" alt="QR" class="h-12 w-12">
    </div>
</div>
        </div>

        <div class="mt-4 flex items-center gap-2">
            <template x-for="c in colors" :key="c.bg">
                <button type="button" @click="card.bg = c.bg; card.fg = c.fg"
                        class="h-8 w-8 rounded-full border-2" :style="`background:${c.bg}`"
                        :class="card.bg === c.bg ? 'border-tuwaiq-orange' : 'border-gray-300'"></button>
            </template>
            <select x-model="card.font" class="ml-auto rounded-lg border py-1 pl-2 pr-8 text-sm text-tuwaiq-purple">>
                <option value="Georgia, serif">Serif</option>
                <option value="Arial, sans-serif">Sans</option>
                <option value="'Courier New', monospace">Mono</option>
            </select>
        </div>
<label class="mt-3 flex items-center gap-2 text-sm text-tuwaiq-purple">
    <input type="checkbox" x-model="card.stamp"> Add stamp (tagline + QR)
</label>
        <button type="button" @click="downloadCard()" class="btn-primary mt-4 w-full">Download PNG</button>
    </div>
</div>
<div x-show="focus.open" x-cloak x-transition.opacity
     @keydown.escape.window="stopFocus()"
     class="fixed inset-0 z-[60] flex flex-col items-center justify-center bg-gradient-to-br from-[#2a1f4d] via-[#3b2d6b] to-[#1b1236] p-8 text-center">

    <button @click="stopFocus()" class="absolute right-6 top-6 text-3xl text-white/60 hover:text-white">✕</button>

    <template x-for="(q, idx) in focus.items" :key="idx">
        <div x-show="focus.i === idx" x-transition.opacity.duration.700ms class="max-w-3xl">
            <p class="text-3xl leading-relaxed text-[#f5ecdf] sm:text-4xl" x-text="'“' + q.text + '”'"></p>
            <p class="mt-6 text-[#cbb8ff]" x-text="'— ' + q.author"></p>
        </div>
    </template>

    <button @click="nextFocus()" class="absolute bottom-10 rounded-full bg-white/10 px-6 py-2 text-white hover:bg-white/20">Next →</button>
    <p class="absolute bottom-3 text-xs text-white/40">Press Esc to leave</p>
</div>
    </main>
</body>
</html>