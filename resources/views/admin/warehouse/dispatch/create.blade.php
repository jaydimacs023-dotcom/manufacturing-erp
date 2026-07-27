@extends('layouts.app')

@section('page-header', 'Create Dispatch')
@section('page-description', 'Create a new dispatch record')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.warehouse.dispatch.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Dispatch Number" name="dispatch_number" id="dispatch_number" value="{{ old('dispatch_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Dispatch Type" name="dispatch_type" id="dispatch_type" :required="true" :options="$dispatchTypes" :selected="old('dispatch_type')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id')" />
                <x-input label="Reference Number" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" help="e.g. SO or EO number" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="$products->pluck('product_name', 'id')->toArray()" :selected="old('product_id')" />
                <x-input label="Quantity" name="quantity" id="quantity" type="number" step="0.0001" :required="true" value="{{ old('quantity') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Batch Number" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" />
                <x-input label="Destination" name="destination" id="destination" value="{{ old('destination') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Vehicle Number" name="vehicle_number" id="vehicle_number" value="{{ old('vehicle_number') }}" />
                <x-input label="Container Number" name="container_number" id="container_number" value="{{ old('container_number') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Seal Number" name="seal_number" id="seal_number" value="{{ old('seal_number') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.warehouse.dispatch.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Dispatch</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

