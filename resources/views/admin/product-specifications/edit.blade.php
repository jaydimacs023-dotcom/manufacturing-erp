@extends('layouts.app')

@section('page-header', 'Edit Specification')
@section('page-description', 'Update specification for ' . $product->product_name)

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.products.specifications.update', [$product, $specification]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-input label="Specification Name" name="spec_name" id="spec_name" :required="true" value="{{ old('spec_name', $specification->spec_name) }}" />
                <x-input label="Specification Value" name="spec_value" id="spec_value" :required="true" value="{{ old('spec_value', $specification->spec_value) }}" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.products.specifications.index', $product) }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Specification</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

