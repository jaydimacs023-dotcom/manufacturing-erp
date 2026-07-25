@extends('layouts.app')

@section('page-header', 'Edit Product')
@section('page-description', 'Update product information')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.products.update', $product) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Product Name" name="product_name" id="product_name" :required="true" value="{{ old('product_name', $product->product_name) }}" />
                <x-input label="Product Code" name="product_code" id="product_code" value="{{ old('product_code', $product->product_code) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product Type" name="product_type" id="product_type" :required="true" :options="$productTypes" :selected="old('product_type', $product->product_type)" />
                <x-select label="Category" name="category_id" id="category_id" :required="true" :options="$categories->pluck('category_name', 'id')->toArray()" :selected="old('category_id', $product->category_id)" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Default UOM" name="default_uom_id" id="default_uom_id" :required="true" :options="$uoms->pluck('uom_name', 'id')->toArray()" :selected="old('default_uom_id', $product->default_uom_id)" />
                <x-input label="Shelf Life (days)" name="shelf_life_days" id="shelf_life_days" type="number" value="{{ old('shelf_life_days', $product->shelf_life_days) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description', $product->description) }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', $product->is_active)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.products.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Product</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

