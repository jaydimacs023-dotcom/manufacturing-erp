@extends('layouts.app')

@section('page-header', 'Export Orders')
@section('page-description', 'Manage export shipment orders')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="">All Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="planned" {{ request('status') === 'planned' ? 'selected' : '' }}>Planned</option>
                <option value="loaded" {{ request('status') === 'loaded' ? 'selected' : '' }}>Loaded</option>
                <option value="dispatched" {{ request('status') === 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                <option value="in_transit" {{ request('status') === 'in_transit' ? 'selected' : '' }}>In Transit</option>
                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        @can('export-order-create')
            <x-button variant="primary" href="{{ route('admin.sales.export-orders.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Export Order
            </x-button>
        @endcan
    </div>

    <x-table :headers="['EO #', 'Customer', 'Destination', 'Port of Loading', 'ETD', 'ETA', 'Status', 'Actions']" :rows="$exportOrders->map(fn($eo) => (object)[
        'cells' => [
            $eo->export_order_number,
            $eo->customer->partner_name ?? '-',
            $eo->destination_country,
            $eo->port_of_loading ?? '-',
            $eo->etd ? $eo->etd->format('Y-m-d') : '-',
            $eo->eta ? $eo->eta->format('Y-m-d') : '-',
            view('components.badge', ['status' => $eo->status === 'delivered' ? 'active' : ($eo->status === 'cancelled' ? 'inactive' : ($eo->status === 'planned' ? 'info' : 'in-progress'))])->with('slot', ucfirst(str_replace('_', ' ', $eo->status))),
            view('admin.sales.export-orders._actions', ['exportOrder' => $eo])->render(),
        ]
    ])" empty="No export orders found.">
    </x-table>

    <div class="mt-4">
        {{ $exportOrders->links() }}
    </div>
</div>
@endsection

