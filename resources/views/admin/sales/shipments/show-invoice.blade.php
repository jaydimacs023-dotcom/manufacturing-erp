@extends('layouts.app')

@section('page-header', $commercialInvoice->invoice_number)
@section('page-description', 'Commercial invoice details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-card title="Invoice Information">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Invoice Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $commercialInvoice->invoice_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Export Order</dt>
                    <dd class="text-sm text-gray-700">{{ $commercialInvoice->exportOrder->export_order_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Customer</dt>
                    <dd class="text-sm text-gray-700">{{ $commercialInvoice->customer->partner_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Total Amount</dt>
                    <dd class="text-sm font-semibold text-gray-900">{{ number_format($commercialInvoice->total_amount, 2) }} {{ $commercialInvoice->currency }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Notes</dt>
                    <dd class="text-sm text-gray-700">{{ $commercialInvoice->notes ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.sales.shipments.index') }}">Back to List</x-button>
    </div>
</div>
@endsection

