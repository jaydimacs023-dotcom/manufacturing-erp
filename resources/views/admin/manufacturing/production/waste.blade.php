@extends('layouts.app')

@section('page-header', 'Record Waste')
@section('page-description', 'Record production waste')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.manufacturing.production.store-waste') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select label="Manufacturing Order" name="manufacturing_order_id" id="manufacturing_order_id" :required="true" :options="$orders->pluck('mo_number', 'id')->toArray()" :selected="old('manufacturing_order_id')" />
                <x-select label="Waste Type" name="waste_type" id="waste_type" :required="true" :options="$wasteTypes" :selected="old('waste_type')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="[]" />
                <x-select label="UOM" name="uom_id" id="uom_id" :required="true" :options="[]" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Quantity" name="quantity" id="quantity" type="number" step="0.0001" :required="true" value="{{ old('quantity') }}" />
                <x-input label="Reason" name="reason" id="reason" :required="true" value="{{ old('reason') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.manufacturing.production.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Record Waste</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
