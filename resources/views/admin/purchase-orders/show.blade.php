@extends('layouts.app')

@section('page-header', $purchaseOrder->purchase_order_number)
@section('page-description', 'Purchase order details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Order Information" description="Basic order details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">PO Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $purchaseOrder->purchase_order_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$purchaseOrder->status === 'approved' ? 'active' : ($purchaseOrder->status === 'draft' ? 'info' : ($purchaseOrder->status === 'cancelled' ? 'inactive' : 'warning'))">
                            {{ ucwords(str_replace('_', ' ', $purchaseOrder->status)) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Expected Delivery</dt>
                    <dd class="text-sm text-gray-700">{{ $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('Y-m-d') : 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Currency</dt>
                    <dd class="text-sm text-gray-700">{{ $purchaseOrder->currency ?? 'PHP' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Supplier Information" description="Vendor details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Supplier</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $purchaseOrder->supplier->partner_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Payment Term</dt>
                    <dd class="text-sm text-gray-700">{{ $purchaseOrder->paymentTerm->term_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Delivery Address</dt>
                    <dd class="text-sm text-gray-700">{{ $purchaseOrder->delivery_address ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Source" description="Purchase request reference">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Purchase Request</dt>
                    <dd class="text-sm font-medium text-gray-900">
                        @if($purchaseOrder->purchaseRequest)
                            <a href="{{ route('admin.purchase-requests.show', $purchaseOrder->purchaseRequest) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $purchaseOrder->purchaseRequest->request_number }}
                            </a>
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Department</dt>
                    <dd class="text-sm text-gray-700">{{ $purchaseOrder->purchaseRequest->department->department_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <x-card title="Order Items" description="Items in this purchase order">
        @if($purchaseOrder->items->count() > 0)
            <x-table :headers="['Product', 'UOM', 'Quantity', 'Unit Cost', 'Total Cost', 'Remarks']" :rows="$purchaseOrder->items->map(fn($item) => (object)[
                'cells' => [
                    $item->product->product_name ?? '-',
                    $item->uom->uom_code ?? '-',
                    number_format($item->quantity_ordered, 4),
                    number_format($item->unit_cost, 2),
                    number_format($item->total_cost, 2),
                    $item->remarks ?? '-',
                ]
            ])" empty="No items.">
            </x-table>
            <div class="mt-4 text-right">
                <p class="text-sm font-medium text-gray-900">Total: {{ number_format($purchaseOrder->items->sum('total_cost'), 2) }}</p>
            </div>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No items added yet.</p>
        @endif
    </x-card>

    @if($purchaseOrder->goodsReceipts->count() > 0)
    <x-card title="Goods Receipts" description="Receiving history">
        <x-table :headers="['GR #', 'Date', 'Status', 'Actions']" :rows="$purchaseOrder->goodsReceipts->map(fn($gr) => (object)[
            'cells' => [
                $gr->goods_receipt_number,
                $gr->date_received->format('Y-m-d'),
                view('components.badge', ['status' => $gr->status === 'completed' ? 'active' : ($gr->status === 'draft' ? 'info' : 'inactive')])->with('slot', ucfirst($gr->status)),
                '<a href="'.route('admin.goods-receipts.show', $gr).'" class="text-blue-600 hover:text-blue-800 text-sm">View</a>',
            ]
        ])" empty="No goods receipts.">
        </x-table>
    </x-card>
    @endif

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.purchase-orders.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('purchase-order-update')
                @if($purchaseOrder->status === 'draft')
                    <a href="{{ route('admin.purchase-orders.edit', $purchaseOrder) }}">
                        <x-button variant="secondary" type="button">Edit</x-button>
                    </a>
                @endif
            @endcan
            @can('purchase-order-approve')
                @if($purchaseOrder->status === 'draft')
                    <form action="{{ route('admin.purchase-orders.approve', $purchaseOrder) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Approve</x-button>
                    </form>
                @endif
            @endcan
            @can('purchase-order-send')
                @if($purchaseOrder->status === 'approved')
                    <form action="{{ route('admin.purchase-orders.send', $purchaseOrder) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Send to Supplier</x-button>
                    </form>
                @endif
            @endcan
            @can('purchase-order-close')
                @if(in_array($purchaseOrder->status, ['sent', 'fully_received']))
                    <form action="{{ route('admin.purchase-orders.close', $purchaseOrder) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Close</x-button>
                    </form>
                @endif
            @endcan
            @can('purchase-order-cancel')
                @if(!in_array($purchaseOrder->status, ['closed', 'cancelled']))
                    <form action="{{ route('admin.purchase-orders.cancel', $purchaseOrder) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel Order</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
