@extends('layouts.app')

@section('page-header', 'Create Product Category')
@section('page-description', 'Add a new product category')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.product-categories.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <x-input label="Category Name" name="category_name" id="category_name" :required="true" value="{{ old('category_name') }}" />
                <x-input label="Category Code" name="category_code" id="category_code" value="{{ old('category_code') }}" help="Leave empty for auto-generation." />
                <x-textarea label="Description" name="description" id="description">{{ old('description') }}</x-textarea>
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', true)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.product-categories.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Category</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

