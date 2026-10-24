@props(['quote'])

{{-- Insight of the Day: one highlighted quote, with a copy button --}}
<div class="fade-up mb-8 rounded-3xl border border-tuwaiq-orange/40 bg-gradient-to-br from-tuwaiq-purple to-[#1a0b3b] p-6 text-white shadow-xl"
     x-data="{ copied: false }">
    <p class="text-sm font-semibold text-tuwaiq-orange">✦ Insight of the Day · إدراك اليوم</p>
    <p class="mt-3 text-2xl leading-relaxed">“{{ $quote->text }}”</p>
    <p class="mt-3 text-sm opacity-80">— {{ $quote->user->name }}</p>
    <button type="button" class="btn-secondary mt-4"
            @click="navigator.clipboard.writeText(@js($quote->text)); copied = true; setTimeout(() => copied = false, 2000)">
        <span x-show="!copied">Copy</span>
        <span x-show="copied" x-cloak>Copied ✓</span>
    </button>
</div>
