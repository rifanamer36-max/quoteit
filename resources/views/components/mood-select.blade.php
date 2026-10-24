@props(['selected' => null, 'placeholder' => 'Choose a mood'])

{{-- Mood list used when sharing and when editing a quote --}}
<select name="mood" required {{ $attributes->merge(['class' => 'input']) }}>
    <option value="" disabled {{ $selected ? '' : 'selected' }}>{{ $placeholder }}</option>
    @foreach (\App\Models\Quote::MOODS as $key => $label)
        <option value="{{ $key }}" {{ $selected === $key ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select>
