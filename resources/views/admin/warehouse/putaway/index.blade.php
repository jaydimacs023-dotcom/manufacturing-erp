@extends('layouts.app')

@section('page-header', 'Put-away')
@section('page-description', 'Manage storage assignments for incoming materials')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search put-away..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.warehouse.putaway.index') }}">All Status</option>
                <option value="{{ route('admin.warehouse.putaway.index', ['status' => 'pending']) }}" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="{{ route('admin.warehouse.putaway.index', ['status' => 'completed']) }}" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="{{ route('admin.warehouse.putaway.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @can('putaway-create')
                <x-button variant="primary" href="{{ route('admin.warehouse.putaway.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Put-away
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['Put-away #', 'Product', 'Warehouse', 'Location', 'Qty', 'Date', 'Status', 'Actions']" :rows="$putaways->map(fn($p) => (object)[
        'cells' => [
            $p->putaway_number,
            $p->product->product_name ?? '-',
            $p->warehouse->warehouse_name ?? '-',
            $p->storageLocation->location_code ?? '-',
            number_format($p->quantity, 0),
            $p->putaway_date ? $p->putaway_date->format('Y-m-d') : '-',
            view('components.badge', ['status' => $p->status === 'completed' ? 'active' : ($p->status === 'cancelled' ? 'inactive' : 'info')])->with('slot', ucfirst($p->status)),
            view('admin.warehouse.putaway._actions', ['putaway' => $p])->render(),
        ]
    ])" empty="No put-away records found.">
    </x-table>

    <div class="mt-4">
        {{ $putaways->links() }}
    </div>
</div>
@endsection

