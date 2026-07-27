@extends('layouts.app')

@section('page-header', 'Purchase Orders')
@section('page-description', 'Manage purchase orders sent to suppliers')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search purchase orders..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.purchase-orders.index') }}">All Status</option>
                <option value="{{ route('admin.purchase-orders.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.purchase-orders.index', ['status' => 'approved']) }}" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="{{ route('admin.purchase-orders.index', ['status' => 'sent']) }}" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                <option value="{{ route('admin.purchase-orders.index', ['status' => 'partially_received']) }}" {{ request('status') === 'partially_received' ? 'selected' : '' }}>Partially Received</option>
                <option value="{{ route('admin.purchase-orders.index', ['status' => 'fully_received']) }}" {{ request('status') === 'fully_received' ? 'selected' : '' }}>Fully Received</option>
                <option value="{{ route('admin.purchase-orders.index', ['status' => 'closed']) }}" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                <option value="{{ route('admin.purchase-orders.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @can('purchase-order-create')
                <x-button variant="primary" href="{{ route('admin.purchase-orders.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Purchase Order
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['PO #', 'Supplier', 'Date', 'Expected Delivery', 'Amount', 'Status', 'Actions']" :rows="$purchaseOrders->map(fn($po) => (object)[
        'cells' => [
            $po->purchase_order_number,
            $po->supplier->partner_name ?? '-',
            $po->created_at->format('Y-m-d'),
            $po->expected_delivery_date ? $po->expected_delivery_date->format('Y-m-d') : '-',
            number_format($po->items->sum('total_cost'), 2),
            view('components.badge', ['status' => $po->status === 'approved' ? 'active' : ($po->status === 'draft' ? 'info' : ($po->status === 'cancelled' ? 'inactive' : 'warning'))])->with('slot', ucwords(str_replace('_', ' ', $po->status))),
            view('admin.purchase-orders._actions', ['purchaseOrder' => $po])->render(),
        ]
    ])" empty="No purchase orders found." actionLabel="New Purchase Order" actionRoute="{{ route('admin.purchase-orders.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $purchaseOrders->links() }}
    </div>
</div>
@endsection
