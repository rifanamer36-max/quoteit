{{-- Calm session: full-screen quotes, one after another --}}
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
