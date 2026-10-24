{{-- "Share a quote": the + button and its window (uses the "open" state of the page) --}}
<button @click="open = true" aria-label="Share a quote"
        class="fixed bottom-8 right-8 z-40 flex h-16 w-16 items-center justify-center rounded-full bg-tuwaiq-purple text-4xl text-white shadow-xl transition hover:scale-110 hover:bg-tuwaiq-purple-light">
    +
</button>

<div x-show="open" x-cloak x-transition.opacity.duration.250ms
     class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
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

            <x-mood-select :selected="old('mood')" placeholder="How does it feel?" />
            @error('mood')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror

            <button class="btn-primary w-full">Send</button>
        </form>
    </div>
</div>
