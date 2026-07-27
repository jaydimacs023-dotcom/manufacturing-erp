@extends('layouts.app')

@section('page-header', 'Create Manufacturing Order')
@section('page-description', 'Plan a new production order')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.manufacturing.orders.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="MO Number" name="mo_number" id="mo_number" value="{{ old('mo_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Priority" name="priority" id="priority" :options="['normal' => 'Normal', 'low' => 'Low', 'high' => 'High', 'urgent' => 'Urgent']" :selected="old('priority', 'normal')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="$products->pluck('product_name', 'id')->toArray()" :selected="old('product_id')" />
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Planned Quantity" name="planned_quantity" id="planned_quantity" type="number" step="0.0001" :required="true" value="{{ old('planned_quantity', 1) }}" />
                <x-select label="UOM" name="uom_id" id="uom_id" :required="true" :options="[]" :selected="old('uom_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Planned Start Date" name="planned_start_date" id="planned_start_date" type="date" :required="true" value="{{ old('planned_start_date', date('Y-m-d')) }}" />
                <x-input label="Planned End Date" name="planned_end_date" id="planned_end_date" type="date" :required="true" value="{{ old('planned_end_date', date('Y-m-d', strtotime('+1 day'))) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.manufacturing.orders.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Order</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
