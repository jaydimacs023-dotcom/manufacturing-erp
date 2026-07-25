@props(['label' => '', 'name' => '', 'id' => null, 'required' => false, 'error' => null, 'help' => ''])

@php
$id = $id ?? $name;
@endphp

<div class="space-y-1">
    @if($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input
        id="{{ $id }}"
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm shadow-sm placeholder-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 disabled:bg-gray-100 disabled:text-gray-500 ' . ($error ? 'border-red-300 text-red-900 focus:border-red-500 focus:ring-red-500' : '')]) }}
    />

    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif

    @if($help)
        <p class="text-xs text-gray-500">{{ $help }}</p>
    @endif
</div>

