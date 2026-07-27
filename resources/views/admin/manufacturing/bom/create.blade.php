@extends('layouts.app')

@section('page-header', 'Create Bill of Materials')
@section('page-description', 'Define a new BOM for a product')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.manufacturing.bom.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="BOM Number" name="bom_number" id="bom_number" value="{{ old('bom_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Status" name="status" id="status" :options="['draft' => 'Draft', 'active' => 'Active']" :selected="'draft'" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="$products->pluck('product_name', 'id')->toArray()" :selected="old('product_id')" />
                <x-select label="UOM" name="uom_id" id="uom_id" :required="true" :options="$products->first()?->defaultUom ? [$products->first()->default_uom_id => $products->first()->defaultUom->uom_code] : []" :selected="old('uom_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Version" name="version" id="version" :required="true" value="{{ old('version', '1.0') }}" />
                <x-input label="Effective Date" name="effective_date" id="effective_date" type="date" :required="true" value="{{ old('effective_date', date('Y-m-d')) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Total Quantity" name="total_quantity" id="total_quantity" type="number" step="0.0001" :required="true" value="{{ old('total_quantity', 1) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description') }}</x-textarea>
            </div>

            <div class="mt-6">
                <h4 class="text-sm font-medium text-gray-700 mb-2">BOM Items</h4>
                <p class="text-xs text-gray-500 mb-4">List the raw materials/components required.</p>
                <div id="bom-items">
                    <div class="bom-item border border-gray-200 rounded-lg p-4 mb-3">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Product *</label>
                                <select name="items[0][product_id]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                                    <option value="">Select Product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">UOM *</label>
                                <select name="items[0][uom_id]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                                    <option value="">Select UOM</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Quantity *</label>
                                <input type="number" step="0.0001" name="items[0][quantity]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Waste %</label>
                                <input type="number" step="0.01" name="items[0][waste_percentage]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" value="0">
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="button" onclick="this.closest('.bom-item').remove()" class="text-xs text-red-600 hover:text-red-800">Remove Item</button>
                        </div>
                    </div>
                </div>
                <button type="button" onclick="addBomItem()" class="text-sm text-blue-600 hover:text-blue-800">+ Add Item</button>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.manufacturing.bom.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save BOM</x-button>
            </div>
        </form>
    </x-card>
</div>

@push('scripts')
<script>
let itemIndex = 1;
function addBomItem() {
    const container = document.getElementById('bom-items');
    const template = `
        <div class="bom-item border border-gray-200 rounded-lg p-4 mb-3">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Product *</label>
                    <select name="items[${itemIndex}][product_id]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">UOM *</label>
                    <select name="items[${itemIndex}][uom_id]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                        <option value="">Select UOM</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Quantity *</label>
                    <input type="number" step="0.0001" name="items[${itemIndex}][quantity]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Waste %</label>
                    <input type="number" step="0.01" name="items[${itemIndex}][waste_percentage]" class="block w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" value="0">
                </div>
            </div>
            <div class="mt-2">
                <button type="button" onclick="this.closest('.bom-item').remove()" class="text-xs text-red-600 hover:text-red-800">Remove Item</button>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', template);
    itemIndex++;
}
</script>
@endpush
@endsection
