@extends('layouts.app')

@section('page-header', 'Create Inventory Transfer')
@section('page-description', 'Transfer stock between warehouses')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.inventory.transfers.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Transfer Number" name="transfer_number" id="transfer_number" value="{{ old('transfer_number') }}" help="Leave empty for auto-generation." />
                <x-select label="From Warehouse" name="from_warehouse_id" id="from_warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('from_warehouse_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="To Warehouse" name="to_warehouse_id" id="to_warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('to_warehouse_id')" />
                <x-input label="Transfer Date" name="transfer_date" id="transfer_date" type="date" :required="true" value="{{ old('transfer_date', date('Y-m-d')) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.inventory.transfers.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Transfer</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
