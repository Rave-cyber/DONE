@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-blue-900']) }}>
    {{ $value ?? $slot }}
</label>
