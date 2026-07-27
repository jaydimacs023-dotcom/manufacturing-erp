@extends('layouts.app')

@section('page-header', 'Create Commercial Invoice')
@section('page-description', 'Create a new commercial invoice for an export order')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.sales.shipments.store-invoice') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Invoice Number" name="invoice_number" id="invoice_number" value="{{ old('invoice_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Export Order" name="export_order_id" id="export_order_id" :required="true" :options="$exportOrders->pluck('export_order_number', 'id')->toArray()" :selected="old('export_order_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Customer" name="customer_id" id="customer_id" :required="true" :options="$customers->pluck('partner_name', 'id')->toArray()" :selected="old('customer_id')" />
                <x-select label="Currency" name="currency" id="currency" :options="['USD' => 'USD', 'IDR' => 'IDR', 'EUR' => 'EUR']" :selected="old('currency', 'USD')" />
            </div>

            <div class="mt-4">
                <x-input label="Total Amount" name="total_amount" id="total_amount" type="number" step="0.01" min="0" :required="true" value="{{ old('total_amount') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Notes" name="notes" id="notes">{{ old('notes') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.sales.shipments.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Invoice</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

