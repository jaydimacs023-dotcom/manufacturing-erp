@extends('layouts.app')

@section('page-header', 'Create Inventory Adjustment')
@section('page-description', 'Record a physical count adjustment')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.inventory.adjustments.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Adjustment Number" name="adjustment_number" id="adjustment_number" value="{{ old('adjustment_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id')" />
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
                ]" :selected="old('reason')" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.inventory.adjustments.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Adjustment</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

