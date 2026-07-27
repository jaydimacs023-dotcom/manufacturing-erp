@extends('layouts.app')

@section('page-header', $dispatch->dispatch_number)
@section('page-description', 'Dispatch details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Dispatch Information" description="Basic details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Dispatch Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $dispatch->dispatch_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$dispatch->status === 'dispatched' ? 'active' : ($dispatch->status === 'cancelled' ? 'inactive' : ($dispatch->status === 'loaded' ? 'in-progress' : 'info'))">
                            {{ ucfirst($dispatch->status) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Type</dt>
                    <dd class="text-sm text-gray-700">{{ ucfirst($dispatch->dispatch_type) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->product->product_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Quantity</dt>
                    <dd class="text-sm text-gray-700">{{ number_format($dispatch->quantity, 0) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Batch Number</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->batch_number ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Destination & Transport" description="Shipping details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Destination</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->destination ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Vehicle Number</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->vehicle_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Container Number</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->container_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Seal Number</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->seal_number ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Timeline" description="Key dates">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Dispatch Date</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->dispatch_date ? $dispatch->dispatch_date->format('Y-m-d') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Loaded At</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->loaded_at ? $dispatch->loaded_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Dispatched At</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->dispatched_at ? $dispatch->dispatched_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Reference</dt>
                    <dd class="text-sm text-gray-700">{{ $dispatch->reference_number ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.warehouse.dispatch.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('dispatch-create')
                @if($dispatch->status === 'draft')
                    <form action="{{ route('admin.warehouse.dispatch.pack', $dispatch) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Mark Packed</x-button>
                    </form>
                @endif
                @if($dispatch->status === 'packed')
                    <form action="{{ route('admin.warehouse.dispatch.load', $dispatch) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Mark Loaded</x-button>
                    </form>
                @endif
                @if($dispatch->status === 'loaded')
                    <form action="{{ route('admin.warehouse.dispatch.confirm', $dispatch) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Confirm Dispatch</x-button>
                    </form>
                @endif
                @if(!in_array($dispatch->status, ['dispatched', 'cancelled']))
                    <form action="{{ route('admin.warehouse.dispatch.cancel', $dispatch) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this dispatch?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

