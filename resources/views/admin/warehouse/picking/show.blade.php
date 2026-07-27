@extends('layouts.app')

@section('page-header', $picking->picking_number)
@section('page-description', 'Picking list details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Picking Information" description="Basic details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Picking Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $picking->picking_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$picking->status === 'completed' ? 'active' : ($picking->status === 'cancelled' ? 'inactive' : ($picking->status === 'in_progress' ? 'in-progress' : 'info'))">
                            {{ ucwords(str_replace('_', ' ', $picking->status)) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Type</dt>
                    <dd class="text-sm text-gray-700">{{ ucfirst($picking->picking_type) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm text-gray-700">{{ $picking->warehouse->warehouse_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Picking Date</dt>
                    <dd class="text-sm text-gray-700">{{ $picking->picking_date ? $picking->picking_date->format('Y-m-d') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Assigned To</dt>
                    <dd class="text-sm text-gray-700">{{ $picking->assignedTo->name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <x-card title="Picking Items" description="Items to pick">
        @if($picking->items->count() > 0)
            <x-table :headers="['Product', 'Required Qty', 'Picked Qty', 'Location', 'Batch #']" :rows="$picking->items->map(fn($item) => (object)[
                'cells' => [
                    $item->product->product_name ?? '-',
                    number_format($item->required_quantity, 4),
                    number_format($item->picked_quantity, 4),
                    $item->storageLocation->location_code ?? '-',
                    $item->batch_number ?? '-',
                ]
            ])" empty="No items.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No items in this picking list.</p>
        @endif
    </x-card>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.warehouse.picking.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('picking-create')
                @if(in_array($picking->status, ['pending', 'in_progress']))
                    <form action="{{ route('admin.warehouse.picking.complete', $picking) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Complete Picking</x-button>
                    </form>
                @endif
                @if(!in_array($picking->status, ['completed', 'cancelled']))
                    <form action="{{ route('admin.warehouse.picking.cancel', $picking) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this picking list?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

