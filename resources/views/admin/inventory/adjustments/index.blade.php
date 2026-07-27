@extends('layouts.app')

@section('page-header', 'Inventory Adjustments')
@section('page-description', 'Manage inventory count adjustments')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search adjustments..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.inventory.adjustments.index') }}">All Status</option>
                <option value="{{ route('admin.inventory.adjustments.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.inventory.adjustments.index', ['status' => 'pending_approval']) }}" {{ request('status') === 'pending_approval' ? 'selected' : '' }}>Pending Approval</option>
                <option value="{{ route('admin.inventory.adjustments.index', ['status' => 'approved']) }}" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="{{ route('admin.inventory.adjustments.index', ['status' => 'rejected']) }}" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="{{ route('admin.inventory.adjustments.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @can('inventory-adjust')
                <x-button variant="primary" href="{{ route('admin.inventory.adjustments.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Adjustment
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['Adjustment #', 'Warehouse', 'Reason', 'Date', 'Status', 'Actions']" :rows="$adjustments->map(fn($adj) => (object)[
        'cells' => [
            $adj->adjustment_number,
            $adj->warehouse->warehouse_name ?? '-',
            ucwords(str_replace('_', ' ', $adj->reason)),
            $adj->created_at->format('Y-m-d'),
            view('components.badge', ['status' => $adj->status === 'approved' ? 'active' : ($adj->status === 'rejected' || $adj->status === 'cancelled' ? 'inactive' : ($adj->status === 'pending_approval' ? 'warning' : 'info'))])->with('slot', ucwords(str_replace('_', ' ', $adj->status))),
            view('admin.inventory.adjustments._actions', ['adjustment' => $adj])->render(),
        ]
    ])" empty="No adjustments found." actionLabel="New Adjustment" actionRoute="{{ route('admin.inventory.adjustments.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $adjustments->links() }}
    </div>
</div>
@endsection

