@extends('layouts.app')

@section('page-header', $goodsReceipt->goods_receipt_number)
@section('page-description', 'Goods receipt details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Receipt Information" description="Basic receipt details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">GR Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $goodsReceipt->goods_receipt_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Date Received</dt>
                    <dd class="text-sm text-gray-700">{{ $goodsReceipt->date_received->format('Y-m-d') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$goodsReceipt->status === 'completed' ? 'active' : ($goodsReceipt->status === 'draft' ? 'info' : 'inactive')">
                            {{ ucfirst($goodsReceipt->status) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Received By</dt>
                    <dd class="text-sm text-gray-700">{{ $goodsReceipt->received_by ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Purchase Order Reference" description="Related PO details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">PO Number</dt>
                    <dd class="text-sm font-medium text-gray-900">
                        @if($goodsReceipt->purchaseOrder)
                            <a href="{{ route('admin.purchase-orders.show', $goodsReceipt->purchaseOrder) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $goodsReceipt->purchaseOrder->purchase_order_number }}
                            </a>
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Supplier</dt>
                    <dd class="text-sm text-gray-700">{{ $goodsReceipt->purchaseOrder->supplier->partner_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Delivery Receipt #</dt>
                    <dd class="text-sm text-gray-700">{{ $goodsReceipt->delivery_receipt_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Supplier Invoice #</dt>
                    <dd class="text-sm text-gray-700">{{ $goodsReceipt->supplier_invoice_number ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Warehouse" description="Storage location">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $goodsReceipt->warehouse->warehouse_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <x-card title="Received Items" description="Items received">
        @if($goodsReceipt->items->count() > 0)
            <x-table :headers="['Product', 'UOM', 'Qty Ordered', 'Qty Received', 'Unit Cost', 'Batch #', 'Expiry Date']" :rows="$goodsReceipt->items->map(fn($item) => (object)[
                'cells' => [
                    $item->product->product_name ?? '-',
                    $item->uom->uom_code ?? '-',
                    number_format($item->quantity_ordered, 4),
                    number_format($item->quantity_received, 4),
                    number_format($item->unit_cost, 2),
                    $item->batch_number ?? '-',
                    $item->expiry_date ? $item->expiry_date->format('Y-m-d') : '-',
                ]
            ])" empty="No items.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No items received yet.</p>
        @endif
    </x-card>

    @if($goodsReceipt->supplierReturns->count() > 0)
    <x-card title="Supplier Returns" description="Returns from this receipt">
        <x-table :headers="['Return #', 'Date', 'Reason', 'Status', 'Actions']" :rows="$goodsReceipt->supplierReturns->map(fn($sr) => (object)[
            'cells' => [
                $sr->supplier_return_number,
                $sr->return_date->format('Y-m-d'),
                ucwords(str_replace('_', ' ', $sr->reason)),
                view('components.badge', ['status' => $sr->status === 'completed' ? 'active' : ($sr->status === 'draft' ? 'info' : 'inactive')])->with('slot', ucfirst($sr->status)),
                '<a href="'.route('admin.supplier-returns.show', $sr).'" class="text-blue-600 hover:text-blue-800 text-sm">View</a>',
            ]
        ])" empty="No returns.">
        </x-table>
    </x-card>
    @endif

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.goods-receipts.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('goods-receipt-update')
                @if($goodsReceipt->status === 'draft')
                    <a href="{{ route('admin.goods-receipts.edit', $goodsReceipt) }}">
                        <x-button variant="secondary" type="button">Edit</x-button>
                    </a>
                    <form action="{{ route('admin.goods-receipts.complete', $goodsReceipt) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Complete Receipt</x-button>
                    </form>
                @endif
            @endcan
            @can('goods-receipt-cancel')
                @if(!in_array($goodsReceipt->status, ['completed', 'cancelled']))
                    <form action="{{ route('admin.goods-receipts.cancel', $goodsReceipt) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this receipt?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel Receipt</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
