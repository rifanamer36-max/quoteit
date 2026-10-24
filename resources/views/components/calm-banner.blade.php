@props(['quotes'])

@php
    // The quotes shown one after another in the calm session
    $focusItems = $quotes->map(fn ($q) => ['text' => $q->text, 'author' => $q->user->name])->values();
@endphp

<div class="fade-up mb-8 flex flex-col items-center justify-between gap-3 rounded-2xl border border-white/20 bg-white/5 p-5 text-white sm:flex-row">
    <div>
        <p class="font-semibold">Need a moment of calm?</p>
        <p class="text-sm opacity-70" dir="rtl">تحتاج لحظة صفاء ذهني؟</p>
    </div>
    <button type="button" class="btn-secondary" @click="startFocus(@js($focusItems))">
        Start a calm session ☕
    </button>
</div>
