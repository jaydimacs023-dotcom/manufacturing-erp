@extends('layouts.app')

@section('page-header', $billOfMaterial->bom_number)
@section('page-description', 'Bill of Materials details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="BOM Information" description="Basic BOM details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">BOM Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $billOfMaterial->bom_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$billOfMaterial->status === 'approved' || $billOfMaterial->status === 'active' ? 'active' : ($billOfMaterial->status === 'inactive' ? 'inactive' : 'info')">
                            {{ ucfirst($billOfMaterial->status) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Version</dt>
                    <dd class="text-sm text-gray-700">{{ $billOfMaterial->version }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Effective Date</dt>
                    <dd class="text-sm text-gray-700">{{ $billOfMaterial->effective_date ? $billOfMaterial->effective_date->format('Y-m-d') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Description</dt>
                    <dd class="text-sm text-gray-700">{{ $billOfMaterial->description ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Product" description="Finished product">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $billOfMaterial->product->product_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Total Quantity</dt>
                    <dd class="text-sm text-gray-700">{{ number_format($billOfMaterial->total_quantity, 4) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">UOM</dt>
                    <dd class="text-sm text-gray-700">{{ $billOfMaterial->uom->uom_code ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <x-card title="BOM Items" description="Materials required">
        @if($billOfMaterial->items->count() > 0)
            <x-table :headers="['Product', 'UOM', 'Quantity', 'Waste %', 'Unit Cost', 'Total Cost']" :rows="$billOfMaterial->items->map(fn($item) => (object)[
                'cells' => [
                    $item->product->product_name ?? '-',
                    $item->uom->uom_code ?? '-',
                    number_format($item->quantity, 4),
                    $item->waste_percentage ? number_format($item->waste_percentage, 2) . '%' : '-',
                    $item->unit_cost ? number_format($item->unit_cost, 2) : '-',
                    $item->total_cost ? number_format($item->total_cost, 2) : '-',
                ]
            ])" empty="No items.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No items in this BOM.</p>
        @endif
    </x-card>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.manufacturing.bom.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('bom-update')
                @if(in_array($billOfMaterial->status, ['draft']))
                    <a href="{{ route('admin.manufacturing.bom.edit', $billOfMaterial) }}">
                        <x-button variant="secondary" type="button">Edit</x-button>
                    </a>
                    <form action="{{ route('admin.manufacturing.bom.approve', $billOfMaterial) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Approve</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
