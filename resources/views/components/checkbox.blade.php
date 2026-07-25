@props(['label' => '', 'name' => '', 'id' => null, 'checked' => false])

@php
$id = $id ?? $name;
@endphp

<label for="{{ $id }}" class="flex items-center space-x-2 cursor-pointer">
    <input
        type="checkbox"
        id="{{ $id }}"
        name="{{ $name }}"
        value="1"
        {{ $checked ? 'checked' : '' }}
        {{ $attributes->merge(['class' => 'rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500']) }}
    />
    @if($label)
        <span class="text-sm text-gray-700">{{ $label }}</span>
    @endif
</label>

