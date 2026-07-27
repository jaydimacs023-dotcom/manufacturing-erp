@extends('layouts.app')

@section('page-header', 'Issue Materials')
@section('page-description', 'Issue raw materials to production')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.manufacturing.production.store-issue') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select label="Manufacturing Order" name="manufacturing_order_id" id="manufacturing_order_id" :required="true" :options="$orders->pluck('mo_number', 'id')->toArray()" :selected="old('manufacturing_order_id')" />
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id')" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description') }}</x-textarea>
            </div>

            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Materials</h4>
                <div id="issue-items">
                    <div class="issue-item border border-gray-200 rounded-lg p-4 mb-3">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Product *</label>
                                <select name="items[0][product_id]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                                    <option value="">Select Product</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">UOM *</label>
                                <select name="items[0][uom_id]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                                    <option value="">Select UOM</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Quantity Issued *</label>
                                <input type="number" step="0.0001" name="items[0][quantity_issued]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Unit Cost</label>
                                <input type="number" step="0.0001" name="items[0][unit_cost]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" value="0">
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" onclick="this.closest('.issue-item').remove()" class="text-xs text-red-600 hover:text-red-800">Remove Item</button>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addIssueItem()" class="text-sm text-blue-600 hover:text-blue-800">+ Add Item</button>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.manufacturing.production.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Issue Materials</x-button>
            </div>
        </form>
    </x-card>
</div>

@push('scripts')
<script>
let itemIndex = 1;
function addIssueItem() {
    const container = document.getElementById('issue-items');
    const template = `
        <div class="issue-item border border-gray-200 rounded-lg p-4 mb-3">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Product *</label>
                    <select name="items[${itemIndex}][product_id]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                        <option value="">Select Product</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">UOM *</label>
                    <select name="items[${itemIndex}][uom_id]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                        <option value="">Select UOM</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Quantity Issued *</label>
                    <input type="number" step="0.0001" name="items[${itemIndex}][quantity_issued]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Unit Cost</label>
                    <input type="number" step="0.0001" name="items[${itemIndex}][unit_cost]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" value="0">
                </div>
            </div>
            <div class="mt-2">
                <button type="button" onclick="this.closest('.issue-item').remove()" class="text-xs text-red-600 hover:text-red-800">Remove Item</button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
    itemIndex++;
}
</script>
@endpush
@endsection
