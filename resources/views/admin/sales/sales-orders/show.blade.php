@extends('layouts.app')

@section('page-header', $salesOrder->sales_order_number)
@section('page-description', 'Sales order details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Order Information" description="Basic details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Order Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $salesOrder->sales_order_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$salesOrder->status === 'shipped' || $salesOrder->status === 'closed' ? 'active' : ($salesOrder->status === 'cancelled' ? 'inactive' : ($salesOrder->status === 'confirmed' || $salesOrder->status === 'allocated' ? 'in-progress' : 'info'))">
                            {{ ucfirst(str_replace('_', ' ', $salesOrder->status)) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Customer</dt>
                    <dd class="text-sm text-gray-700">{{ $salesOrder->customer->partner_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Order Date</dt>
                    <dd class="text-sm text-gray-700">{{ $salesOrder->order_date ? $salesOrder->order_date->format('Y-m-d') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Delivery Date</dt>
                    <dd class="text-sm text-gray-700">{{ $salesOrder->delivery_date ? $salesOrder->delivery_date->format('Y-m-d') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Currency</dt>
                    <dd class="text-sm text-gray-700">{{ $salesOrder->currency }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Total Amount</dt>
                    <dd class="text-sm font-semibold text-gray-900">{{ number_format($salesOrder->total_amount, 2) }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Notes">
            <p class="text-sm text-gray-700">{{ $salesOrder->notes ?? 'No notes.' }}</p>
        </x-card>

        <x-card title="Approval">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Approved By</dt>
                    <dd class="text-sm text-gray-700">{{ $salesOrder->approver->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Approved At</dt>
                    <dd class="text-sm text-gray-700">{{ $salesOrder->approved_at ? $salesOrder->approved_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <!-- Order Items -->
    <x-card title="Order Items">
        <x-table :headers="['Product', 'Quantity', 'Unit Price', 'Subtotal', 'Allocated Qty']" :rows="$salesOrder->items->map(fn($item) => (object)[
            'cells' => [
                $item->product->product_name ?? '-',
                number_format($item->quantity, 2),
                number_format($item->unit_price, 2),
                number_format($item->subtotal, 2),
                number_format($item->allocated_quantity, 2),
            ]
        ])" empty="No items.">
        </x-table>
    </x-card>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.sales.sales-orders.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('sales-order-create')
                @if($salesOrder->status === 'draft')
                    <form action="{{ route('admin.sales.sales-orders.submit', $salesOrder) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Submit Order</x-button>
                    </form>
                @endif
                @if($salesOrder->status === 'confirmed')
                    <form action="{{ route('admin.sales.sales-orders.approve', $salesOrder) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Approve & Allocate</x-button>
                    </form>
                @endif
                @if(!in_array($salesOrder->status, ['closed', 'cancelled']))
                    <form action="{{ route('admin.sales.sales-orders.cancel', $salesOrder) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this sales order?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

