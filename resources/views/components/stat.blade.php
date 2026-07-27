@props([
    'label' => '',
    'value' => '',
    'color' => 'blue',
])

@php
    $colorClasses = match ($color) {
        'green' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'red' => 'bg-red-50 text-red-700 border-red-200',
        'yellow' => 'bg-amber-50 text-amber-700 border-amber-200',
        'blue' => 'bg-blue-50 text-blue-700 border-blue-200',
        'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'violet' => 'bg-violet-50 text-violet-700 border-violet-200',
        default => 'bg-blue-50 text-blue-700 border-blue-200',
    };
@endphp

<div {{ $attributes->merge(['class' => 'rounded-lg border p-5 ' . $colorClasses]) }}>
    <p class="text-sm font-medium opacity-80">{{ $label }}</p>
    <p class="mt-1 text-2xl font-bold tracking-tight">{{ $value }}</p>
    {{ $slot ?? '' }}
</div>

