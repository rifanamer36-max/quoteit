{{-- Mood compass: filters the quotes by mood (uses the "mood" state of the page) --}}
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
