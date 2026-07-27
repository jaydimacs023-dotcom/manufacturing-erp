@extends('layouts.app')

@section('page-header', 'Shipments')
@section('page-description', 'Manage packing lists, invoices, and shipment tracking')

@section('content')
<div class="space-y-6">
    <!-- Packing Lists -->
    <x-card title="Packing Lists">
        <div class="flex items-center justify-between mb-4">
            <div></div>
            @can('shipment-create')
                <x-button variant="primary" href="{{ route('admin.sales.shipments.create-packing-list') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Packing List
                </x-button>
            @endcan
        </div>

        <x-table :headers="['PL #', 'Export Order', 'Product', 'Qty', 'Cartons', 'Net Wt', 'Gross Wt', 'Actions']" :rows="$packingLists->map(fn($pl) => (object)[
            'cells' => [
                $pl->packing_list_number,
                $pl->exportOrder->export_order_number ?? '-',
                $pl->product->product_name ?? '-',
                number_format($pl->quantity, 2),
                $pl->number_of_cartons ?? '-',
                $pl->net_weight ? number_format($pl->net_weight, 2) : '-',
                $pl->gross_weight ? number_format($pl->gross_weight, 2) : '-',
                view('admin.sales.shipments._actions', ['item' => $pl, 'type' => 'packing-list'])->render(),
            ]
        ])" empty="No packing lists.">
        </x-table>

        <div class="mt-4">
            {{ $packingLists->links() }}
        </div>
    </x-card>

    <!-- Commercial Invoices -->
    <x-card title="Commercial Invoices">
        <div class="flex items-center justify-between mb-4">
            <div></div>
            @can('shipment-create')
                <x-button variant="primary" href="{{ route('admin.sales.shipments.create-invoice') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Commercial Invoice
                </x-button>
            @endcan
        </div>

        <x-table :headers="['Invoice #', 'Export Order', 'Customer', 'Total', 'Currency', 'Actions']" :rows="$invoices->map(fn($inv) => (object)[
            'cells' => [
                $inv->invoice_number,
                $inv->exportOrder->export_order_number ?? '-',
                $inv->customer->partner_name ?? '-',
                number_format($inv->total_amount, 2),
                $inv->currency,
                view('admin.sales.shipments._actions', ['item' => $inv, 'type' => 'invoice'])->render(),
            ]
        ])" empty="No commercial invoices.">
        </x-table>

        <div class="mt-4">
            {{ $invoices->links() }}
        </div>
    </x-card>
</div>
@endsection

