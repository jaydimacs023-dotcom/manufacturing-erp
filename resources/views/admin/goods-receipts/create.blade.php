@extends('layouts.app')

@section('page-header', 'Create Goods Receipt')
@section('page-description', 'Record incoming goods from a supplier delivery')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.goods-receipts.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="GR Number" name="goods_receipt_number" id="goods_receipt_number" value="{{ old('goods_receipt_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Purchase Order" name="purchase_order_id" id="purchase_order_id" :required="true" :options="$purchaseOrders->mapWithKeys(fn($po) => [$po->id => $po->purchase_order_number . ' - ' . ($po->supplier->partner_name ?? '')])->toArray()" :selected="old('purchase_order_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Delivery Receipt #" name="delivery_receipt_number" id="delivery_receipt_number" value="{{ old('delivery_receipt_number') }}" />
                <x-input label="Supplier Invoice #" name="supplier_invoice_number" id="supplier_invoice_number" value="{{ old('supplier_invoice_number') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Date Received" name="date_received" id="date_received" type="date" :required="true" value="{{ old('date_received', date('Y-m-d')) }}" />
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id')" />
            </div>

            <div class="mt-4">
                <x-input label="Received By" name="received_by" id="received_by" :required="true" value="{{ old('received_by', auth()->user()->name ?? '') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.goods-receipts.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Goods Receipt</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
