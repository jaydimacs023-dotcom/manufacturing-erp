@extends('layouts.app')

@section('page-header', 'Create Packing List')
@section('page-description', 'Create a new packing list for an export order')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.sales.shipments.store-packing-list') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Packing List Number" name="packing_list_number" id="packing_list_number" value="{{ old('packing_list_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Export Order" name="export_order_id" id="export_order_id" :required="true" :options="$exportOrders->pluck('export_order_number', 'id')->toArray()" :selected="old('export_order_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="$products->pluck('product_name', 'id')->toArray()" :selected="old('product_id')" />
                <x-input label="Quantity" name="quantity" id="quantity" type="number" step="0.0001" :required="true" value="{{ old('quantity') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <x-input label="Batch Number" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" />
                <x-input label="Number of Cartons" name="number_of_cartons" id="number_of_cartons" type="number" value="{{ old('number_of_cartons') }}" />
                <x-input label="Net Weight" name="net_weight" id="net_weight" type="number" step="0.01" value="{{ old('net_weight') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Gross Weight" name="gross_weight" id="gross_weight" type="number" step="0.01" value="{{ old('gross_weight') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.sales.shipments.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Packing List</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

