@extends('layouts.app')

@section('page-header', 'Sales Orders')
@section('page-description', 'Manage customer sales orders')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="">All Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="allocated" {{ request('status') === 'allocated' ? 'selected' : '' }}>Allocated</option>
                <option value="ready_for_shipment" {{ request('status') === 'ready_for_shipment' ? 'selected' : '' }}>Ready for Shipment</option>
                <option value="shipped" {{ request('status') === 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        @can('sales-order-create')
            <x-button variant="primary" href="{{ route('admin.sales.sales-orders.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Sales Order
            </x-button>
        @endcan
    </div>

    <x-table :headers="['SO #', 'Customer', 'Order Date', 'Delivery Date', 'Total', 'Status', 'Actions']" :rows="$salesOrders->map(fn($so) => (object)[
        'cells' => [
            $so->sales_order_number,
            $so->customer->partner_name ?? '-',
            $so->order_date ? $so->order_date->format('Y-m-d') : '-',
            $so->delivery_date ? $so->delivery_date->format('Y-m-d') : '-',
            number_format($so->total_amount, 2),
            view('components.badge', ['status' => $so->status === 'shipped' || $so->status === 'closed' ? 'active' : ($so->status === 'cancelled' ? 'inactive' : ($so->status === 'confirmed' || $so->status === 'allocated' ? 'in-progress' : 'info'))])->with('slot', ucfirst(str_replace('_', ' ', $so->status))),
            view('admin.sales.sales-orders._actions', ['salesOrder' => $so])->render(),
        ]
    ])" empty="No sales orders found.">
    </x-table>

    <div class="mt-4">
        {{ $salesOrders->links() }}
    </div>
</div>
@endsection

