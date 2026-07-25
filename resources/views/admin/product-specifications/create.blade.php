@extends('layouts.app')

@section('page-header', 'Add Specification')
@section('page-description', 'Add specification for ' . $product->product_name)

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.products.specifications.store', $product) }}" method="POST">
            @csrf

            <div class="space-y-4">
                <x-input label="Specification Name" name="spec_name" id="spec_name" :required="true" value="{{ old('spec_name') }}" placeholder="e.g., Moisture Content" />
                <x-input label="Specification Value" name="spec_value" id="spec_value" :required="true" value="{{ old('spec_value') }}" placeholder="e.g., < 5%" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.products.specifications.index', $product) }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Add Specification</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

