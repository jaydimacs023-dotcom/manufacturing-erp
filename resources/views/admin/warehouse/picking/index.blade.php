@extends('layouts.app')

@section('page-header', 'Material Picking')
@section('page-description', 'Manage picking lists for production and shipment')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm ml-2" onchange="window.location.href=this.value">
                <option value="">All Types</option>
                <option value="production" {{ request('type') === 'production' ? 'selected' : '' }}>Production</option>
                <option value="shipment" {{ request('type') === 'shipment' ? 'selected' : '' }}>Shipment</option>
                <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>Transfer</option>
            </select>
        </div>
        @can('picking-create')
            <x-button variant="primary" href="{{ route('admin.warehouse.picking.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Picking
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Picking #', 'Type', 'Warehouse', 'Items', 'Date', 'Status', 'Actions']" :rows="$pickings->map(fn($p) => (object)[
        'cells' => [
            $p->picking_number,
            ucfirst($p->picking_type),
            $p->warehouse->warehouse_name ?? '-',
            $p->items_count ?? $p->items->count() ?? '-',
            $p->picking_date ? $p->picking_date->format('Y-m-d') : '-',
            view('components.badge', ['status' => $p->status === 'completed' ? 'active' : ($p->status === 'cancelled' ? 'inactive' : ($p->status === 'in_progress' ? 'in-progress' : 'info'))])->with('slot', ucwords(str_replace('_', ' ', $p->status))),
            view('admin.warehouse.picking._actions', ['picking' => $p])->render(),
        ]
    ])" empty="No picking lists found.">
    </x-table>

    <div class="mt-4">
        {{ $pickings->links() }}
    </div>
</div>
@endsection

