@extends('layouts.app')

@section('page-header', $inventoryAdjustment->adjustment_number)
@section('page-description', 'Inventory adjustment details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Adjustment Information" description="Basic adjustment details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Adjustment #</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $inventoryAdjustment->adjustment_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$inventoryAdjustment->status === 'approved' ? 'active' : ($inventoryAdjustment->status === 'rejected' || $inventoryAdjustment->status === 'cancelled' ? 'inactive' : ($inventoryAdjustment->status === 'pending_approval' ? 'warning' : 'info'))">
                            {{ ucwords(str_replace('_', ' ', $inventoryAdjustment->status)) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Reason</dt>
                    <dd class="text-sm text-gray-700">{{ ucwords(str_replace('_', ' ', $inventoryAdjustment->reason)) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Description</dt>
                    <dd class="text-sm text-gray-700">{{ $inventoryAdjustment->description ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Warehouse" description="Adjustment location">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $inventoryAdjustment->warehouse->warehouse_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Approval" description="Approval status">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Approved By</dt>
                    <dd class="text-sm text-gray-700">{{ $inventoryAdjustment->approver->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Approved At</dt>
                    <dd class="text-sm text-gray-700">{{ $inventoryAdjustment->approved_at ? $inventoryAdjustment->approved_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
                @if($inventoryAdjustment->rejection_reason)
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Rejection Reason</dt>
                    <dd class="text-sm text-red-600">{{ $inventoryAdjustment->rejection_reason }}</dd>
                </div>
                @endif
            </dl>
        </x-card>
    </div>

    <x-card title="Adjusted Items" description="Items in this adjustment">
        @if($inventoryAdjustment->items->count() > 0)
            <x-table :headers="['Product', 'UOM', 'Expected Qty', 'Actual Qty', 'Difference', 'Batch #']" :rows="$inventoryAdjustment->items->map(fn($item) => (object)[
                'cells' => [
                    $item->product->product_name ?? '-',
                    $item->uom->uom_code ?? '-',
                    number_format($item->expected_quantity, 4),
                    number_format($item->actual_quantity, 4),
                    view('components.badge', ['status' => $item->difference >= 0 ? 'active' : 'inactive'])->with('slot', ($item->difference >= 0 ? '+' : '') . number_format($item->difference, 4)),
                    $item->batch_number ?? '-',
                ]
            ])" empty="No items.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No items in this adjustment.</p>
        @endif
    </x-card>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.inventory.adjustments.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('inventory-adjust')
                @if($inventoryAdjustment->status === 'draft')
                    <a href="{{ route('admin.inventory.adjustments.edit', $inventoryAdjustment) }}">
                        <x-button variant="secondary" type="button">Edit</x-button>
                    </a>
                    <form action="{{ route('admin.inventory.adjustments.submit', $inventoryAdjustment) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Submit for Approval</x-button>
                    </form>
                @endif
                @if($inventoryAdjustment->status === 'pending_approval')
                    <form action="{{ route('admin.inventory.adjustments.approve', $inventoryAdjustment) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Approve</x-button>
                    </form>
                    <form action="{{ route('admin.inventory.adjustments.reject', $inventoryAdjustment) }}" method="POST" class="inline" onsubmit="return prompt('Enter rejection reason:') ? (document.getElementById('reject-reason').value = prompt('Enter rejection reason:')) : false">
                        @csrf
                        <input type="hidden" name="rejection_reason" id="reject-reason">
                        <x-button variant="secondary" type="submit">Reject</x-button>
                    </form>
                @endif
                @if(!in_array($inventoryAdjustment->status, ['approved', 'rejected', 'cancelled']))
                    <form action="{{ route('admin.inventory.adjustments.cancel', $inventoryAdjustment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this adjustment?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

