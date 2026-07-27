@extends('layouts.app')

@section('page-header', 'Goods Receipts')
@section('page-description', 'Manage incoming goods received from suppliers')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search goods receipts..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.goods-receipts.index') }}">All Status</option>
                <option value="{{ route('admin.goods-receipts.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.goods-receipts.index', ['status' => 'completed']) }}" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="{{ route('admin.goods-receipts.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @can('goods-receipt-create')
                <x-button variant="primary" href="{{ route('admin.goods-receipts.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Goods Receipt
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['GR #', 'PO #', 'Supplier', 'Date Received', 'Warehouse', 'Status', 'Actions']" :rows="$goodsReceipts->map(fn($gr) => (object)[
        'cells' => [
            $gr->goods_receipt_number,
            $gr->purchaseOrder->purchase_order_number ?? '-',
            $gr->purchaseOrder->supplier->partner_name ?? '-',
            $gr->date_received->format('Y-m-d'),
            $gr->warehouse->warehouse_name ?? '-',
            view('components.badge', ['status' => $gr->status === 'completed' ? 'active' : ($gr->status === 'draft' ? 'info' : 'inactive')])->with('slot', ucfirst($gr->status)),
            view('admin.goods-receipts._actions', ['goodsReceipt' => $gr])->render(),
        ]
    ])" empty="No goods receipts found." actionLabel="New Goods Receipt" actionRoute="{{ route('admin.goods-receipts.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $goodsReceipts->links() }}
    </div>
</div>
@endsection
