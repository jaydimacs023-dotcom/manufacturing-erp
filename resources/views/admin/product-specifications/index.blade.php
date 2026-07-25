@extends('layouts.app')

@section('page-header', 'Specifications for ' . $product->product_name)
@section('page-description', 'Manage product specifications')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div></div>
        @can('product-update')
            <x-button variant="primary" href="{{ route('admin.products.specifications.create', $product) }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Specification
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Name', 'Value', 'Actions']" :rows="$specifications->map(fn($s) => (object)[
        'cells' => [
            $s->spec_name,
            $s->spec_value,
            view('admin.product-specifications._actions', ['product' => $product, 'specification' => $s])->render(),
        ]
    ])" empty="No specifications found.">
    </x-table>

    <div class="flex items-center justify-start">
        <x-button variant="secondary" href="{{ route('admin.products.show', $product) }}">Back to Product</x-button>
    </div>
</div>
@endsection

