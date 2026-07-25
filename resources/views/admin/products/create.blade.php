@extends('layouts.app')

@section('page-header', 'Create Product')
@section('page-description', 'Add a new product or material')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.products.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Product Name" name="product_name" id="product_name" :required="true" value="{{ old('product_name') }}" />
                <x-input label="Product Code" name="product_code" id="product_code" value="{{ old('product_code') }}" help="Leave empty for auto-generation." />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product Type" name="product_type" id="product_type" :required="true" :options="$productTypes" :selected="old('product_type')" />
                <x-select label="Category" name="category_id" id="category_id" :required="true" :options="$categories->pluck('category_name', 'id')->toArray()" :selected="old('category_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Default UOM" name="default_uom_id" id="default_uom_id" :required="true" :options="$uoms->pluck('uom_name', 'id')->toArray()" :selected="old('default_uom_id')" />
                <x-input label="Shelf Life (days)" name="shelf_life_days" id="shelf_life_days" type="number" value="{{ old('shelf_life_days') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', true)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.products.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Product</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

