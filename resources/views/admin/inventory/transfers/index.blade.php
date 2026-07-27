@extends('layouts.app')

@section('page-header', 'Inventory Transfers')
@section('page-description', 'Manage stock transfers between warehouses')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search transfers..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.inventory.transfers.index') }}">All Status</option>
                <option value="{{ route('admin.inventory.transfers.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.inventory.transfers.index', ['status' => 'completed']) }}" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="{{ route('admin.inventory.transfers.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @can('inventory-transfer')
                <x-button variant="primary" href="{{ route('admin.inventory.transfers.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Transfer
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['Transfer #', 'From', 'To', 'Date', 'Status', 'Actions']" :rows="$transfers->map(fn($t) => (object)[
        'cells' => [
            $t->transfer_number,
            $t->fromWarehouse->warehouse_name ?? '-',
            $t->toWarehouse->warehouse_name ?? '-',
            $t->transfer_date->format('Y-m-d'),
            view('components.badge', ['status' => $t->status === 'completed' ? 'active' : ($t->status === 'draft' ? 'info' : 'inactive')])->with('slot', ucfirst($t->status)),
            view('admin.inventory.transfers._actions', ['transfer' => $t])->render(),
        ]
    ])" empty="No transfers found." actionLabel="New Transfer" actionRoute="{{ route('admin.inventory.transfers.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $transfers->links() }}
    </div>
</div>
@endsection
