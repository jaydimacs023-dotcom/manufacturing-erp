@extends('layouts.app')

@section('page-header', $supplierReturn->supplier_return_number)
@section('page-description', 'Supplier return details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Return Information" description="Basic return details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Return Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $supplierReturn->supplier_return_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Return Date</dt>
                    <dd class="text-sm text-gray-700">{{ $supplierReturn->return_date->format('Y-m-d') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$supplierReturn->status === 'completed' ? 'active' : ($supplierReturn->status === 'draft' ? 'info' : 'inactive')">
                            {{ ucfirst($supplierReturn->status) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Reason</dt>
                    <dd class="text-sm text-gray-700">{{ ucwords(str_replace('_', ' ', $supplierReturn->reason)) }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Source Information" description="Related receipt details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Goods Receipt</dt>
                    <dd class="text-sm font-medium text-gray-900">
                        @if($supplierReturn->goodsReceipt)
                            <a href="{{ route('admin.goods-receipts.show', $supplierReturn->goodsReceipt) }}" class="text-blue-600 hover:text-blue-800">
                                {{ $supplierReturn->goodsReceipt->goods_receipt_number }}
                            </a>
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">PO Number</dt>
                    <dd class="text-sm text-gray-700">{{ $supplierReturn->goodsReceipt->purchaseOrder->purchase_order_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Supplier</dt>
                    <dd class="text-sm text-gray-700">{{ $supplierReturn->goodsReceipt->purchaseOrder->supplier->partner_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Warehouse" description="Return location">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $supplierReturn->warehouse->warehouse_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <x-card title="Returned Items" description="Items being returned">
        @if($supplierReturn->items->count() > 0)
            <x-table :headers="['Product', 'UOM', 'Qty Returned', 'Reason']" :rows="$supplierReturn->items->map(fn($item) => (object)[
                'cells' => [
                    $item->product->product_name ?? '-',
                    $item->uom->uom_code ?? '-',
                    number_format($item->quantity_returned, 4),
                    $item->reason ?? ucwords(str_replace('_', ' ', $supplierReturn->reason)),
                ]
            ])" empty="No items.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No items returned yet.</p>
        @endif
    </x-card>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.supplier-returns.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('supplier-return-update')
                @if($supplierReturn->status === 'draft')
                    <a href="{{ route('admin.supplier-returns.edit', $supplierReturn) }}">
                        <x-button variant="secondary" type="button">Edit</x-button>
                    </a>
                    <form action="{{ route('admin.supplier-returns.complete', $supplierReturn) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Complete Return</x-button>
                    </form>
                @endif
            @endcan
            @can('supplier-return-cancel')
                @if(!in_array($supplierReturn->status, ['completed', 'cancelled']))
                    <form action="{{ route('admin.supplier-returns.cancel', $supplierReturn) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this return?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel Return</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
