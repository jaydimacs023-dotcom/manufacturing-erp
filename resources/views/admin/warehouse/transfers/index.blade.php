@extends('layouts.app')

@section('page-header', 'Warehouse Transfers')
@section('page-description', 'Manage internal warehouse movements')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.warehouse.transfers.index') }}">All Status</option>
                <option value="{{ route('admin.warehouse.transfers.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.warehouse.transfers.index', ['status' => 'approved']) }}" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="{{ route('admin.warehouse.transfers.index', ['status' => 'completed']) }}" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="{{ route('admin.warehouse.transfers.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        @can('inventory-transfer')
            <x-button variant="primary" href="{{ route('admin.warehouse.transfers.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Transfer
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Transfer #', 'Product', 'From', 'To', 'Qty', 'Status', 'Actions']" :rows="$transfers->map(fn($t) => (object)[
        'cells' => [
            $t->transfer_number,
            $t->product->product_name ?? '-',
            $t->sourceWarehouse->warehouse_name ?? '-',
            $t->destinationWarehouse->warehouse_name ?? '-',
            number_format($t->quantity, 0),
            view('components.badge', ['status' => $t->status === 'completed' ? 'active' : ($t->status === 'cancelled' ? 'inactive' : ($t->status === 'approved' ? 'in-progress' : 'info'))])->with('slot', ucfirst($t->status)),
            view('admin.warehouse.transfers._actions', ['transfer' => $t])->render(),
        ]
    ])" empty="No transfers found.">
    </x-table>

    <div class="mt-4">
        {{ $transfers->links() }}
    </div>
</div>
@endsection

