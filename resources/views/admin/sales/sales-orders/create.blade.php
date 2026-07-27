@extends('layouts.app')

@section('page-header', 'Create Sales Order')
@section('page-description', 'Create a new sales order')

@section('content')
<div class="max-w-4xl">
    <x-card>
        <form action="{{ route('admin.sales.sales-orders.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Sales Order Number" name="sales_order_number" id="sales_order_number" value="{{ old('sales_order_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Customer" name="customer_id" id="customer_id" :required="true" :options="$customers->pluck('partner_name', 'id')->toArray()" :selected="old('customer_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Order Date" name="order_date" id="order_date" type="date" value="{{ old('order_date', date('Y-m-d')) }}" />
                <x-input label="Delivery Date" name="delivery_date" id="delivery_date" type="date" value="{{ old('delivery_date') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Currency" name="currency" id="currency" :options="['IDR' => 'IDR', 'USD' => 'USD']" :selected="old('currency', 'IDR')" />
            </div>

            <div class="mt-4">
                <x-textarea label="Notes" name="notes" id="notes">{{ old('notes') }}</x-textarea>
            </div>

            <!-- Order Items -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Order Items</h3>
                <div id="items-container">
                    <div class="grid grid-cols-4 gap-2 mb-2 text-xs font-medium text-gray-500 uppercase">
                        <div>Product</div>
                        <div>Quantity</div>
                        <div>Unit Price</div>
                        <div></div>
                    </div>
                    <div class="item-row grid grid-cols-4 gap-2 mb-2">
                        <select name="items[0][product_id]" class="rounded-lg border border-gray-300 px-3 py-2 text-sm w-full" required>
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                            @endforeach
                        </select>
                        <input type="number" name="items[0][quantity]" step="0.0001" min="0.0001" class="rounded-lg border border-gray-300 px-3 py-2 text-sm w-full" required placeholder="Qty">
                        <input type="number" name="items[0][unit_price]" step="0.01" min="0" class="rounded-lg border border-gray-300 px-3 py-2 text-sm w-full" required placeholder="Price">
                        <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-sm">Remove</button>
                    </div>
                </div>
                <button type="button" onclick="addItem()" class="text-blue-600 hover:text-blue-800 text-sm mt-2">+ Add Item</button>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.sales.sales-orders.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Sales Order</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

@push('scripts')
<script>
    let itemIndex = 1;
    function addItem() {
        const container = document.getElementById('items-container');
        const template = `
            <div class="item-row grid grid-cols-4 gap-2 mb-2">
                <select name="items[${itemIndex}][product_id]" class="rounded-lg border border-gray-300 px-3 py-2 text-sm w-full" required>
                    <option value="">Select Product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->product_name }}</option>
                    @endforeach
                </select>
                <input type="number" name="items[${itemIndex}][quantity]" step="0.0001" min="0.0001" class="rounded-lg border border-gray-300 px-3 py-2 text-sm w-full" required placeholder="Qty">
                <input type="number" name="items[${itemIndex}][unit_price]" step="0.01" min="0" class="rounded-lg border border-gray-300 px-3 py-2 text-sm w-full" required placeholder="Price">
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 text-sm">Remove</button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', template);
        itemIndex++;
    }
</script>
@endpush

