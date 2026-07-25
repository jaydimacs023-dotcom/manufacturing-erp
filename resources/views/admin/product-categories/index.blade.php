@extends('layouts.app')

@section('page-header', 'Product Categories')
@section('page-description', 'Manage product categories')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search categories..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        @can('product-category-create')
            <x-button variant="primary" href="{{ route('admin.product-categories.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Category
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Code', 'Name', 'Description', 'Status', 'Created At', 'Actions']" :rows="$categories->map(fn($c) => (object)[
        'cells' => [
            $c->category_code,
            $c->category_name,
            $c->description ?? '-',
            view('components.badge', ['status' => $c->is_active ? 'active' : 'inactive'])->with('slot', $c->is_active ? 'Active' : 'Inactive'),
            $c->created_at->format('Y-m-d'),
            view('admin.product-categories._actions', ['category' => $c])->render(),
        ]
    ])" empty="No product categories found." actionLabel="New Category" actionRoute="{{ route('admin.product-categories.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>
@endsection

