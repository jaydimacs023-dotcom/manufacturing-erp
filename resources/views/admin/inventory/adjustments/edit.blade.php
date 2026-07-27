@extends('layouts.app')

@section('page-header', 'Edit Inventory Adjustment')
@section('page-description', 'Update adjustment information')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.inventory.adjustments.update', $inventoryAdjustment) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Adjustment Number" name="adjustment_number" id="adjustment_number" :required="true" value="{{ old('adjustment_number', $inventoryAdjustment->adjustment_number) }}" />
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id', $inventoryAdjustment->warehouse_id)" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Reason" name="reason" id="reason" :required="true" :options="[
                    'physical_count' => 'Physical Count',
                    'damage' => 'Damage',
                    'spoilage' => 'Spoilage',
                    'expired' => 'Expired',
                    'missing' => 'Missing',
                    'found' => 'Found',
                    'other' => 'Other',
                ]" :selected="old('reason', $inventoryAdjustment->reason)" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description', $inventoryAdjustment->description) }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks', $inventoryAdjustment->remarks) }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.inventory.adjustments.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Adjustment</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

