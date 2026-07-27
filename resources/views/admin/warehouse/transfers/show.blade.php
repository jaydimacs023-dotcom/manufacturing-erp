@extends('layouts.app')

@section('page-header', $warehouseTransfer->transfer_number)
@section('page-description', 'Warehouse transfer details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Transfer Information" description="Basic details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Transfer Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $warehouseTransfer->transfer_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$warehouseTransfer->status === 'completed' ? 'active' : ($warehouseTransfer->status === 'cancelled' ? 'inactive' : ($warehouseTransfer->status === 'approved' ? 'in-progress' : 'info'))">
                            {{ ucfirst($warehouseTransfer->status) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product</dt>
                    <dd class="text-sm text-gray-700">{{ $warehouseTransfer->product->product_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Quantity</dt>
                    <dd class="text-sm text-gray-700">{{ number_format($warehouseTransfer->quantity, 0) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Batch Number</dt>
                    <dd class="text-sm text-gray-700">{{ $warehouseTransfer->batch_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Reason</dt>
                    <dd class="text-sm text-gray-700">{{ $warehouseTransfer->reason ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Source" description="Origin">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm text-gray-700">{{ $warehouseTransfer->sourceWarehouse->warehouse_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Location</dt>
                    <dd class="text-sm text-gray-700">{{ $warehouseTransfer->sourceLocation->location_code ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Destination" description="Target">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm text-gray-700">{{ $warehouseTransfer->destinationWarehouse->warehouse_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Location</dt>
                    <dd class="text-sm text-gray-700">{{ $warehouseTransfer->destinationLocation->location_code ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.warehouse.transfers.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('inventory-transfer')
                @if($warehouseTransfer->status === 'draft')
                    <form action="{{ route('admin.warehouse.transfers.approve', $warehouseTransfer) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Approve Transfer</x-button>
                    </form>
                @endif
                @if($warehouseTransfer->status === 'approved')
                    <form action="{{ route('admin.warehouse.transfers.complete', $warehouseTransfer) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Complete Transfer</x-button>
                    </form>
                @endif
                @if(!in_array($warehouseTransfer->status, ['completed', 'cancelled']))
                    <form action="{{ route('admin.warehouse.transfers.cancel', $warehouseTransfer) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this transfer?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

