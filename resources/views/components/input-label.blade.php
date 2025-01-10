@props(['value'])

<label {{ $attributes->merge(['class' => 'color-darkwhite block font-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
