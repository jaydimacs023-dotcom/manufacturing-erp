@extends('layouts.app')

@section('page-header', $product->product_name)
@section('page-description', 'Product details and specifications')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Product Information" description="Basic product details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product Code</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $product->product_code }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product Name</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $product->product_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Type</dt>
                    <dd class="text-sm text-gray-700">{{ ucwords(str_replace('_', ' ', $product->product_type)) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$product->is_active ? 'active' : 'inactive'">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </x-badge>
                    </dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Classification" description="Category and UOM">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Category</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $product->category->category_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Default UOM</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $product->defaultUom->uom_code ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Shelf Life</dt>
                    <dd class="text-sm text-gray-700">{{ $product->shelf_life_days ? $product->shelf_life_days . ' days' : 'N/A' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Description" description="Product notes">
            <p class="text-sm text-gray-700">{{ $product->description ?? 'No description provided.' }}</p>
        </x-card>
    </div>

    <x-card title="Specifications" description="Product specifications">
        <div class="flex items-center justify-between mb-4">
            <div></div>
            @can('product-update')
                <x-button variant="primary" size="sm" href="{{ route('admin.products.specifications.create', $product) }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Specification
                </x-button>
            @endcan
        </div>

        @if($product->specifications->count() > 0)
            <x-table :headers="['Name', 'Value', 'Actions']" :rows="$product->specifications->map(fn($s) => (object)[
                'cells' => [
                    $s->spec_name,
                    $s->spec_value,
                    view('admin.product-specifications._actions', ['product' => $product, 'specification' => $s])->render(),
                ]
            ])" empty="No specifications yet.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No specifications added yet.</p>
        @endif
    </x-card>

    <div class="flex items-center justify-end space-x-3">
        <x-button variant="secondary" href="{{ route('admin.products.index') }}">Back to Products</x-button>
        @can('product-update')
            <x-button variant="primary" href="{{ route('admin.products.edit', $product) }}">Edit Product</x-button>
        @endcan
    </div>
</div>
@endsection

