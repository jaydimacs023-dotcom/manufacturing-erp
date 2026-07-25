@extends('layouts.app')

@section('page-header', 'Products')
@section('page-description', 'Manage products and materials')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search products..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        @can('product-create')
            <x-button variant="primary" href="{{ route('admin.products.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Product
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Code', 'Name', 'Type', 'Category', 'UOM', 'Status', 'Actions']" :rows="$products->map(fn($p) => (object)[
        'cells' => [
            $p->product_code,
            $p->product_name,
            ucwords(str_replace('_', ' ', $p->product_type)),
            $p->category->category_name ?? '-',
            $p->defaultUom->uom_code ?? '-',
            view('components.badge', ['status' => $p->is_active ? 'active' : 'inactive'])->with('slot', $p->is_active ? 'Active' : 'Inactive'),
            view('admin.products._actions', ['product' => $p])->render(),
        ]
    ])" empty="No products found." actionLabel="New Product" actionRoute="{{ route('admin.products.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection

