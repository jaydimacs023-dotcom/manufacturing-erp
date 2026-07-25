@props(['status' => ''])

@php
$colors = [
    'draft' => 'bg-gray-100 text-gray-800',
    'submitted' => 'bg-yellow-100 text-yellow-800',
    'approved' => 'bg-green-100 text-green-800',
    'completed' => 'bg-blue-100 text-blue-800',
    'cancelled' => 'bg-gray-200 text-gray-600',
    'rejected' => 'bg-red-100 text-red-800',
    'in-progress' => 'bg-blue-100 text-blue-800',
    'in_progress' => 'bg-blue-100 text-blue-800',
    'closed' => 'bg-gray-300 text-gray-700',
    'active' => 'bg-green-100 text-green-800',
    'inactive' => 'bg-gray-100 text-gray-500',
];

$color = $colors[strtolower($status)] ?? 'bg-gray-100 text-gray-800';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ' . $color]) }}>
    {{ $slot }}
</span>

