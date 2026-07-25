@extends('layouts.app')

@section('page-header', 'Edit Product Category')
@section('page-description', 'Update product category information')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.product-categories.update', $productCategory) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-input label="Category Name" name="category_name" id="category_name" :required="true" value="{{ old('category_name', $productCategory->category_name) }}" />
                <x-input label="Category Code" name="category_code" id="category_code" value="{{ old('category_code', $productCategory->category_code) }}" />
                <x-textarea label="Description" name="description" id="description">{{ old('description', $productCategory->description) }}</x-textarea>
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', $productCategory->is_active)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.product-categories.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Category</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

