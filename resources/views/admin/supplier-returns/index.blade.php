@extends('layouts.app')

@section('page-header', 'Supplier Returns')
@section('page-description', 'Manage returns to suppliers')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search returns..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.supplier-returns.index') }}">All Status</option>
                <option value="{{ route('admin.supplier-returns.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.supplier-returns.index', ['status' => 'completed']) }}" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="{{ route('admin.supplier-returns.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @can('supplier-return-create')
                <x-button variant="primary" href="{{ route('admin.supplier-returns.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Supplier Return
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['Return #', 'GR #', 'Supplier', 'Date', 'Reason', 'Status', 'Actions']" :rows="$supplierReturns->map(fn($sr) => (object)[
        'cells' => [
            $sr->supplier_return_number,
            $sr->goodsReceipt->goods_receipt_number ?? '-',
            $sr->goodsReceipt->purchaseOrder->supplier->partner_name ?? '-',
            $sr->return_date->format('Y-m-d'),
            ucwords(str_replace('_', ' ', $sr->reason)),
            view('components.badge', ['status' => $sr->status === 'completed' ? 'active' : ($sr->status === 'draft' ? 'info' : 'inactive')])->with('slot', ucfirst($sr->status)),
            view('admin.supplier-returns._actions', ['supplierReturn' => $sr])->render(),
        ]
    ])" empty="No supplier returns found." actionLabel="New Supplier Return" actionRoute="{{ route('admin.supplier-returns.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $supplierReturns->links() }}
    </div>
</div>
@endsection
