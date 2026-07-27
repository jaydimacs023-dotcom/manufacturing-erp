@extends('layouts.app')

@section('page-header', 'Create Purchase Order')
@section('page-description', 'Create a new purchase order from an approved purchase request')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.purchase-orders.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="PO Number" name="purchase_order_number" id="purchase_order_number" value="{{ old('purchase_order_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Purchase Request" name="purchase_request_id" id="purchase_request_id" :required="true" :options="$purchaseRequests->mapWithKeys(fn($pr) => [$pr->id => $pr->request_number . ' - ' . ($pr->department->department_name ?? '')])->toArray()" :selected="old('purchase_request_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Supplier" name="supplier_id" id="supplier_id" :required="true" :options="$suppliers->pluck('partner_name', 'id')->toArray()" :selected="old('supplier_id')" />
                <x-select label="Payment Term" name="payment_term_id" id="payment_term_id" :required="true" :options="$paymentTerms->pluck('term_name', 'id')->toArray()" :selected="old('payment_term_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Expected Delivery Date" name="expected_delivery_date" id="expected_delivery_date" type="date" value="{{ old('expected_delivery_date') }}" />
                <x-input label="Currency" name="currency" id="currency" value="{{ old('currency', 'PHP') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Delivery Address" name="delivery_address" id="delivery_address">{{ old('delivery_address') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.purchase-orders.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Purchase Order</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
