@extends('layouts.app')

@section('page-header', 'Create Warehouse Transfer')
@section('page-description', 'Move materials between storage locations')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.warehouse.transfers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Transfer Number" name="transfer_number" id="transfer_number" value="{{ old('transfer_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="$products->pluck('product_name', 'id')->toArray()" :selected="old('product_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Source Warehouse" name="source_warehouse_id" id="source_warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('source_warehouse_id')" />
                <x-select label="Source Location" name="source_location_id" id="source_location_id" :required="true" :options="[]" :selected="old('source_location_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Destination Warehouse" name="destination_warehouse_id" id="destination_warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('destination_warehouse_id')" />
                <x-select label="Destination Location" name="destination_location_id" id="destination_location_id" :required="true" :options="[]" :selected="old('destination_location_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Quantity" name="quantity" id="quantity" type="number" step="0.0001" :required="true" value="{{ old('quantity') }}" />
                <x-input label="Batch Number" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" />
            </div>

            <div class="mt-4">
                <x-input label="Reason for Transfer" name="reason" id="reason" value="{{ old('reason') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.warehouse.transfers.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Transfer</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

