@extends('layouts.app')

@section('page-header', $inventoryTransfer->transfer_number)
@section('page-description', 'Transfer details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Transfer Information" description="Basic transfer details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Transfer Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $inventoryTransfer->transfer_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Transfer Date</dt>
                    <dd class="text-sm text-gray-700">{{ $inventoryTransfer->transfer_date->format('Y-m-d') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$inventoryTransfer->status === 'completed' ? 'active' : ($inventoryTransfer->status === 'draft' ? 'info' : 'inactive')">
                            {{ ucfirst($inventoryTransfer->status) }}
                        </x-badge>
                    </dd>
                </div>
            </dl>
        </x-card>

        <x-card title="From Warehouse" description="Source location">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $inventoryTransfer->fromWarehouse->warehouse_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="To Warehouse" description="Destination location">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $inventoryTransfer->toWarehouse->warehouse_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <x-card title="Transferred Items" description="Items in this transfer">
        @if($inventoryTransfer->items->count() > 0)
            <x-table :headers="['Product', 'UOM', 'Quantity', 'Batch #', 'Expiry Date']" :rows="$inventoryTransfer->items->map(fn($item) => (object)[
                'cells' => [
                    $item->product->product_name ?? '-',
                    $item->uom->uom_code ?? '-',
                    number_format($item->quantity, 4),
                    $item->batch_number ?? '-',
                    $item->expiry_date ? $item->expiry_date->format('Y-m-d') : '-',
                ]
            ])" empty="No items.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No items in this transfer.</p>
        @endif
    </x-card>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.inventory.transfers.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('inventory-transfer')
                @if($inventoryTransfer->status === 'draft')
                    <a href="{{ route('admin.inventory.transfers.edit', $inventoryTransfer) }}">
                        <x-button variant="secondary" type="button">Edit</x-button>
                    </a>
                    <form action="{{ route('admin.inventory.transfers.complete', $inventoryTransfer) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Complete Transfer</x-button>
                    </form>
                @endif
                @if(!in_array($inventoryTransfer->status, ['completed', 'cancelled']))
                    <form action="{{ route('admin.inventory.transfers.cancel', $inventoryTransfer) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this transfer?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel Transfer</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
