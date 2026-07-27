@extends('layouts.app')

@section('page-header', 'Edit Inventory Transfer')
@section('page-description', 'Update transfer information')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.inventory.transfers.update', $inventoryTransfer) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Transfer Number" name="transfer_number" id="transfer_number" :required="true" value="{{ old('transfer_number', $inventoryTransfer->transfer_number) }}" />
                <x-select label="From Warehouse" name="from_warehouse_id" id="from_warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('from_warehouse_id', $inventoryTransfer->from_warehouse_id)" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="To Warehouse" name="to_warehouse_id" id="to_warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('to_warehouse_id', $inventoryTransfer->to_warehouse_id)" />
                <x-input label="Transfer Date" name="transfer_date" id="transfer_date" type="date" :required="true" value="{{ old('transfer_date', $inventoryTransfer->transfer_date->format('Y-m-d')) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks', $inventoryTransfer->remarks) }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.inventory.transfers.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Transfer</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
