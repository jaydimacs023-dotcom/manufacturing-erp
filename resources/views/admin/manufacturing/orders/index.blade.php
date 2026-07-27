@extends('layouts.app')

@section('page-header', 'Manufacturing Orders')
@section('page-description', 'Manage production orders')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search orders..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.manufacturing.orders.index') }}">All Status</option>
                <option value="{{ route('admin.manufacturing.orders.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.manufacturing.orders.index', ['status' => 'planned']) }}" {{ request('status') === 'planned' ? 'selected' : '' }}>Planned</option>
                <option value="{{ route('admin.manufacturing.orders.index', ['status' => 'released']) }}" {{ request('status') === 'released' ? 'selected' : '' }}>Released</option>
                <option value="{{ route('admin.manufacturing.orders.index', ['status' => 'in_progress']) }}" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="{{ route('admin.manufacturing.orders.index', ['status' => 'quality_inspection']) }}" {{ request('status') === 'quality_inspection' ? 'selected' : '' }}>QC</option>
                <option value="{{ route('admin.manufacturing.orders.index', ['status' => 'completed']) }}" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="{{ route('admin.manufacturing.orders.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @can('manufacturing-order-create')
                <x-button variant="primary" href="{{ route('admin.manufacturing.orders.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Order
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['MO #', 'Product', 'Planned Qty', 'Start Date', 'End Date', 'Status', 'Actions']" :rows="$orders->map(fn($order) => (object)[
        'cells' => [
            $order->mo_number,
            $order->product->product_name ?? '-',
            number_format($order->planned_quantity, 0),
            $order->planned_start_date ? $order->planned_start_date->format('Y-m-d') : '-',
            $order->planned_end_date ? $order->planned_end_date->format('Y-m-d') : '-',
            view('components.badge', ['status' => $order->status === 'completed' ? 'active' : ($order->status === 'cancelled' ? 'inactive' : ($order->status === 'in_progress' ? 'in-progress' : 'info'))])->with('slot', ucwords(str_replace('_', ' ', $order->status))),
            view('admin.manufacturing.orders._actions', ['order' => $order])->render(),
        ]
    ])" empty="No manufacturing orders found." actionLabel="New Order" actionRoute="{{ route('admin.manufacturing.orders.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
