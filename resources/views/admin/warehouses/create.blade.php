@extends('layouts.app')

@section('page-header', 'Create Warehouse')
@section('page-description', 'Add a new storage facility')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-card>
        <form action="{{ route('admin.warehouses.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <x-input
                    label="Warehouse Name"
                    name="warehouse_name"
                    :value="old('warehouse_name')"
                    required
                    placeholder="e.g. Raw Material Warehouse"
                />

                <x-input
                    label="Warehouse Code"
                    name="warehouse_code"
                    :value="old('warehouse_code')"
                    placeholder="Auto-generated if empty"
                />

                <x-select
                    label="Warehouse Type"
                    name="warehouse_type"
                    :value="old('warehouse_type')"
                    required
                    :options="[
                        'raw_material' => 'Raw Material',
                        'packaging' => 'Packaging',
                        'production' => 'Production',
                        'finished_goods' => 'Finished Goods',
                        'transit' => 'Transit',
                    ]"
                />

                <x-select
                    label="Branch"
                    name="branch_id"
                    :value="old('branch_id')"
                    required
                    :options="$branches->pluck('branch_name', 'id')"
                />

                <x-textarea
                    label="Address"
                    name="address"
                    :value="old('address')"
                    rows="3"
                />

                <x-checkbox
                    label="Active"
                    name="is_active"
                    :checked="old('is_active', true)"
                />

                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
                    <x-button variant="secondary" href="{{ route('admin.warehouses.index') }}">
                        Cancel
                    </x-button>
                    <x-button variant="primary" type="submit">
                        Save Warehouse
                    </x-button>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection

