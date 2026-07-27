@extends('layouts.app')

@section('page-header', 'Create Picking List')
@section('page-description', 'Create a new picking list for materials')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.warehouse.picking.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Picking Number" name="picking_number" id="picking_number" value="{{ old('picking_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Picking Type" name="picking_type" id="picking_type" :required="true" :options="$pickingTypes" :selected="old('picking_type')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id')" />
                <x-input label="Reference Number" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" help="e.g. MO or SO number" />
            </div>

            <div class="mt-4">
                <x-input label="Picking Date" name="picking_date" id="picking_date" type="date" :required="true" value="{{ old('picking_date', date('Y-m-d')) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Picking Items</h4>
                <div id="items-container">
                    <div class="item-row grid grid-cols-3 gap-2 mb-2">
                        <x-select label="Product" name="items[0][product_id]" :required="true" :options="$products->pluck('product_name', 'id')->toArray()" />
                        <x-input label="Required Qty" name="items[0][required_quantity]" type="number" step="0.0001" :required="true" />
                        <x-input label="Batch #" name="items[0][batch_number]" />
                    </div>
                </div>
                <button type="button" onclick="addItem()" class="text-sm text-blue-600 hover:text-blue-800 mt-2">
                    + Add Item
                </button>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.warehouse.picking.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Picking List</x-button>
            </div>
        </form>
    </x-card>
</div>

<script>
let itemIndex = 1;
function addItem() {
    const container = document.getElementById('items-container');
    const row = document.createElement('div');
    row.className = 'item-row grid grid-cols-3 gap-2 mb-2';
    row.innerHTML = `
        <select name="items[${itemIndex}][product_id]" required class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <option value="">Select Product</option>
            @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
            @endforeach
        </select>
        <input type="number" step="0.0001" name="items[${itemIndex}][required_quantity]" required placeholder="Required Qty" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
        <input type="text" name="items[${itemIndex}][batch_number]" placeholder="Batch #" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
    `;
    container.appendChild(row);
    itemIndex++;
}
</script>
@endsection

