@extends('layouts.app')

@section('page-header', 'Inventory Movements')
@section('page-description', 'All stock movement records')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search movements..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.inventory.movements') }}">All Types</option>
                <option value="{{ route('admin.inventory.movements', ['type' => 'receive']) }}" {{ request('type') === 'receive' ? 'selected' : '' }}>Receive</option>
                <option value="{{ route('admin.inventory.movements', ['type' => 'issue']) }}" {{ request('type') === 'issue' ? 'selected' : '' }}>Issue</option>
                <option value="{{ route('admin.inventory.movements', ['type' => 'transfer_in']) }}" {{ request('type') === 'transfer_in' ? 'selected' : '' }}>Transfer In</option>
                <option value="{{ route('admin.inventory.movements', ['type' => 'transfer_out']) }}" {{ request('type') === 'transfer_out' ? 'selected' : '' }}>Transfer Out</option>
                <option value="{{ route('admin.inventory.movements', ['type' => 'adjustment_plus']) }}" {{ request('type') === 'adjustment_plus' ? 'selected' : '' }}>Adjustment +</option>
                <option value="{{ route('admin.inventory.movements', ['type' => 'adjustment_minus']) }}" {{ request('type') === 'adjustment_minus' ? 'selected' : '' }}>Adjustment -</option>
            </select>
        </div>
    </div>

    <x-card>
        @php
            $movementRows = $movements->map(fn ($movement) => (object) [
                'cells' => [
                    $movement->created_at->format('Y-m-d H:i'),
                    $movement->movement_number,
                    new \Illuminate\Support\HtmlString(
                        '<span class="px-2 py-1 text-xs rounded-full '
                        .($movement->quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800')
                        .'">'.e(ucwords(str_replace('_', ' ', $movement->movement_type))).'</span>'
                    ),
                    new \Illuminate\Support\HtmlString(
                        '<a href="'.e(route('admin.inventory.stock-card', $movement->product_id)).'" class="text-blue-600 hover:text-blue-800">'
                        .e($movement->product->product_name ?? '-')
                        .'</a>'
                    ),
                    $movement->warehouse->warehouse_name ?? '-',
                    number_format($movement->quantity, 4),
                    number_format($movement->unit_cost, 2),
                    number_format($movement->total_cost, 2),
                    $movement->batch_number ?? '-',
                    $movement->reference_type
                        ? ucwords(str_replace('_', ' ', $movement->reference_type)).' #'.$movement->reference_id
                        : '-',
                ],
            ]);
        @endphp

        <x-table
            :headers="['Date', 'Movement #', 'Type', 'Product', 'Warehouse', 'Qty', 'Unit Cost', 'Total', 'Batch #', 'Reference']"
            :rows="$movementRows"
            empty="No movements found."
        />

        <div class="mt-4">
            {{ $movements->links() }}
        </div>
    </x-card>
</div>
@endsection
