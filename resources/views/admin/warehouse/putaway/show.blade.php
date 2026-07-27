@extends('layouts.app')

@section('page-header', $putaway->putaway_number)
@section('page-description', 'Put-away details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Put-away Information" description="Basic details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Put-away Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $putaway->putaway_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$putaway->status === 'completed' ? 'active' : ($putaway->status === 'cancelled' ? 'inactive' : 'info')">
                            {{ ucfirst($putaway->status) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->product->product_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Quantity</dt>
                    <dd class="text-sm text-gray-700">{{ number_format($putaway->quantity, 0) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Batch Number</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->batch_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Remarks</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->remarks ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Storage Details" description="Warehouse and location">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->warehouse->warehouse_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Location</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->storageLocation->location_code ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Area</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->storageLocation->storage_area ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Put-away Date</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->putaway_date ? $putaway->putaway_date->format('Y-m-d H:i') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Reference</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->reference_number ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Audit" description="Tracking info">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Created By</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->createdBy->name ?? 'System' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Created At</dt>
                    <dd class="text-sm text-gray-700">{{ $putaway->created_at ? $putaway->created_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.warehouse.putaway.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('putaway-create')
                @if($putaway->status === 'pending')
                    <form action="{{ route('admin.warehouse.putaway.complete', $putaway) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Complete Put-away</x-button>
                    </form>
                    <form action="{{ route('admin.warehouse.putaway.cancel', $putaway) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this put-away?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

