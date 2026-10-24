@props(['quote', 'delay' => 0])

@php
    $mine = auth()->id() === $quote->user_id;
    $liked = auth()->check() && $quote->likedBy->contains(auth()->id());
    $saved = auth()->check() && $quote->savedBy->contains(auth()->id());
    $hasEditErrors = old('quote_id') == $quote->id;
    $currentMood = $hasEditErrors ? old('mood', $quote->mood) : $quote->mood;
@endphp

{{-- One quote card: view mode and edit mode (the owner only) --}}
<div class="fade-up rounded-2xl p-5 shadow {{ $mine ? 'bg-tuwaiq-purple text-white' : 'bg-white text-tuwaiq-purple' }}"
     style="animation-delay: {{ $delay }}ms"
     x-show="(mood === '' || mood === '{{ $quote->mood }}') && (search === '' || @js(mb_strtolower($quote->text . ' ' . $quote->user->name)).includes(search.toLowerCase().trim()))"
     x-transition.opacity.duration.300ms
     x-data="{ editing: {{ $errors->update->any() && $hasEditErrors ? 'true' : 'false' }} }">

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

        <div class="mt-3 flex flex-wrap items-center gap-4 text-sm">
            @auth
                <form method="POST" action="{{ route('quotes.like', $quote) }}">
                    @csrf
                    <button>{{ $liked ? '❤️' : '🤍' }} {{ $quote->likedBy->count() }}</button>
                </form>

                <form method="POST" action="{{ route('quotes.save', $quote) }}">
                    @csrf
                    <button title="Save to My Insights">{{ $saved ? '🔖 Saved' : '📑 Save' }}</button>
                </form>
            @else
                <span>🤍 {{ $quote->likedBy->count() }}</span>
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
                      class="input">{{ $hasEditErrors ? old('text') : $quote->text }}</textarea>
            @if ($hasEditErrors)
                @error('text', 'update')
                    <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                @enderror
            @endif

            <x-mood-select :selected="$currentMood" class="mt-2" />
            @if ($hasEditErrors)
                @error('mood', 'update')
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
