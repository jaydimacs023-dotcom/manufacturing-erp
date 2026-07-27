@extends('layouts.app')

@section('page-header', 'Record Production Output')
@section('page-description', 'Record finished goods from production')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.manufacturing.production.store-output') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select label="Manufacturing Order" name="manufacturing_order_id" id="manufacturing_order_id" :required="true" :options="$orders->pluck('mo_number', 'id')->toArray()" :selected="old('manufacturing_order_id')" />
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="[]" />
                <x-select label="UOM" name="uom_id" id="uom_id" :required="true" :options="[]" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <x-input label="Quantity Produced" name="quantity_produced" id="quantity_produced" type="number" step="0.0001" :required="true" value="{{ old('quantity_produced') }}" />
                <x-input label="Quantity Rejected" name="quantity_rejected" id="quantity_rejected" type="number" step="0.0001" value="{{ old('quantity_rejected', 0) }}" />
                <x-input label="Quantity Waste" name="quantity_waste" id="quantity_waste" type="number" step="0.0001" value="{{ old('quantity_waste', 0) }}" />
            </div>

            <div class="mt-4">
                <x-input label="Batch Number" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" help="Leave empty for auto-generation." />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.manufacturing.production.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Record Output</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
