@extends('layouts.app')

@section('page-header', $purchaseRequest->request_number)
@section('page-description', 'Purchase request details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Request Information" description="Basic request details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Request Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $purchaseRequest->request_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Date</dt>
                    <dd class="text-sm text-gray-700">{{ $purchaseRequest->request_date->format('Y-m-d') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$purchaseRequest->status === 'approved' ? 'active' : ($purchaseRequest->status === 'draft' ? 'info' : ($purchaseRequest->status === 'rejected' || $purchaseRequest->status === 'cancelled' ? 'inactive' : 'warning'))">
                            {{ ucwords(str_replace('_', ' ', $purchaseRequest->status)) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Priority</dt>
                    <dd>
                        <x-badge :status="$purchaseRequest->priority === 'urgent' ? 'danger' : ($purchaseRequest->priority === 'high' ? 'warning' : 'info')">
                            {{ ucfirst($purchaseRequest->priority) }}
                        </x-badge>
                    </dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Department & Requestor" description="Who requested this">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Department</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $purchaseRequest->department->department_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Requested By</dt>
                    <dd class="text-sm text-gray-700">{{ $purchaseRequest->requested_by ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Required Date</dt>
                    <dd class="text-sm text-gray-700">{{ $purchaseRequest->required_date ? $purchaseRequest->required_date->format('Y-m-d') : 'N/A' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Remarks" description="Additional notes">
            <p class="text-sm text-gray-700">{{ $purchaseRequest->remarks ?? 'No remarks.' }}</p>
        </x-card>
    </div>

    <x-card title="Request Items" description="Items requested for purchase">
        @if($purchaseRequest->items->count() > 0)
            <x-table :headers="['Product', 'UOM', 'Quantity', 'Remarks']" :rows="$purchaseRequest->items->map(fn($item) => (object)[
                'cells' => [
                    $item->product->product_name ?? '-',
                    $item->uom->uom_code ?? '-',
                    number_format($item->quantity, 4),
                    $item->remarks ?? '-',
                ]
            ])" empty="No items.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No items added yet.</p>
        @endif
    </x-card>

    @if($purchaseRequest->purchaseOrders->count() > 0)
    <x-card title="Purchase Orders" description="Purchase orders created from this request">
        <x-table :headers="['PO Number', 'Supplier', 'Status', 'Actions']" :rows="$purchaseRequest->purchaseOrders->map(fn($po) => (object)[
            'cells' => [
                $po->purchase_order_number,
                $po->supplier->partner_name ?? '-',
                view('components.badge', ['status' => $po->status === 'approved' ? 'active' : ($po->status === 'draft' ? 'info' : ($po->status === 'cancelled' ? 'inactive' : 'warning'))])->with('slot', ucwords(str_replace('_', ' ', $po->status))),
                '<a href="'.route('admin.purchase-orders.show', $po).'" class="text-blue-600 hover:text-blue-800 text-sm">View</a>',
            ]
        ])" empty="No purchase orders.">
        </x-table>
    </x-card>
    @endif

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.purchase-requests.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('purchase-request-update')
                @if($purchaseRequest->status === 'draft')
                    <form action="{{ route('admin.purchase-requests.submit', $purchaseRequest) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Submit</x-button>
                    </form>
                    <a href="{{ route('admin.purchase-requests.edit', $purchaseRequest) }}">
                        <x-button variant="secondary" type="button">Edit</x-button>
                    </a>
                @endif
            @endcan
            @can('purchase-request-approve')
                @if($purchaseRequest->status === 'submitted')
                    <form action="{{ route('admin.purchase-requests.approve', $purchaseRequest) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Approve</x-button>
                    </form>
                    <form action="{{ route('admin.purchase-requests.reject', $purchaseRequest) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="danger" type="submit">Reject</x-button>
                    </form>
                @endif
            @endcan
            @can('purchase-request-cancel')
                @if(!in_array($purchaseRequest->status, ['cancelled', 'converted_to_po']))
                    <form action="{{ route('admin.purchase-requests.cancel', $purchaseRequest) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this request?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel Request</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
