@extends('layouts.app')

@section('page-header', $manufacturingOrder->mo_number)
@section('page-description', 'Manufacturing Order details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Order Information" description="Basic order details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">MO Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $manufacturingOrder->mo_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$manufacturingOrder->status === 'completed' ? 'active' : ($manufacturingOrder->status === 'cancelled' ? 'inactive' : ($manufacturingOrder->status === 'in_progress' ? 'in-progress' : ($manufacturingOrder->status === 'quality_inspection' ? 'warning' : 'info')))">
                            {{ ucwords(str_replace('_', ' ', $manufacturingOrder->status)) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Priority</dt>
                    <dd class="text-sm text-gray-700">{{ ucfirst($manufacturingOrder->priority ?? 'normal') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Batch Number</dt>
                    <dd class="text-sm text-gray-700">{{ $manufacturingOrder->batch_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Description</dt>
                    <dd class="text-sm text-gray-700">{{ $manufacturingOrder->description ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Schedule" description="Production timeline">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Planned Start</dt>
                    <dd class="text-sm text-gray-700">{{ $manufacturingOrder->planned_start_date ? $manufacturingOrder->planned_start_date->format('Y-m-d') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Planned End</dt>
                    <dd class="text-sm text-gray-700">{{ $manufacturingOrder->planned_end_date ? $manufacturingOrder->planned_end_date->format('Y-m-d') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Actual Start</dt>
                    <dd class="text-sm text-gray-700">{{ $manufacturingOrder->actual_start_date ? $manufacturingOrder->actual_start_date->format('Y-m-d H:i') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Actual End</dt>
                    <dd class="text-sm text-gray-700">{{ $manufacturingOrder->actual_end_date ? $manufacturingOrder->actual_end_date->format('Y-m-d H:i') : '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Product & BOM" description="Production details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $manufacturingOrder->product->product_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Planned Quantity</dt>
                    <dd class="text-sm text-gray-700">{{ number_format($manufacturingOrder->planned_quantity, 0) }} {{ $manufacturingOrder->uom->uom_code ?? '' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">BOM Version</dt>
                    <dd class="text-sm text-gray-700">{{ $manufacturingOrder->bom_version ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm text-gray-700">{{ $manufacturingOrder->warehouse->warehouse_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <!-- MO Items -->
    <x-card title="Required Materials" description="Items needed for production">
        @if($manufacturingOrder->items->count() > 0)
            <x-table :headers="['Product', 'UOM', 'Planned Qty', 'Issued Qty', 'Remaining']" :rows="$manufacturingOrder->items->map(fn($item) => (object)[
                'cells' => [
                    $item->product->product_name ?? '-',
                    $item->uom->uom_code ?? '-',
                    number_format($item->planned_quantity, 4),
                    number_format($item->issued_quantity, 4),
                    number_format($item->planned_quantity - $item->issued_quantity, 4),
                ]
            ])" empty="No items.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No items recorded for this order.</p>
        @endif
    </x-card>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.manufacturing.orders.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('manufacturing-order-update')
                @if(in_array($manufacturingOrder->status, ['draft', 'planned']))
                    <a href="{{ route('admin.manufacturing.orders.edit', $manufacturingOrder) }}">
                        <x-button variant="secondary" type="button">Edit</x-button>
                    </a>
                    <form action="{{ route('admin.manufacturing.orders.release', $manufacturingOrder) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Release & Reserve Materials</x-button>
                    </form>
                @endif
                @if($manufacturingOrder->status === 'released')
                    <form action="{{ route('admin.manufacturing.orders.start', $manufacturingOrder) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Start Production</x-button>
                    </form>
                @endif
                @if($manufacturingOrder->status === 'in_progress')
                    <form action="{{ route('admin.manufacturing.orders.complete', $manufacturingOrder) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Complete Production</x-button>
                    </form>
                @endif
                @if($manufacturingOrder->status === 'quality_inspection')
                    <form action="{{ route('admin.manufacturing.orders.close', $manufacturingOrder) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Close Order</x-button>
                    </form>
                @endif
                @if(!in_array($manufacturingOrder->status, ['completed', 'cancelled']))
                    <form action="{{ route('admin.manufacturing.orders.cancel', $manufacturingOrder) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this order?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel Order</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
