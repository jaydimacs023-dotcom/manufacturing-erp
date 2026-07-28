@extends('layouts.app')

@section('page-header', 'Inventory Overview')
@section('page-description', 'Stock status and inventory summary')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <x-card>
            <div class="text-center">
                <dt class="text-xs font-medium text-gray-500 uppercase">Total Products</dt>
                <dd class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($overview['totalProducts']) }}</dd>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <dt class="text-xs font-medium text-gray-500 uppercase">Stock Value</dt>
                <dd class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($overview['totalStockValue'], 2) }}</dd>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <dt class="text-xs font-medium text-gray-500 uppercase">Total On Hand</dt>
                <dd class="mt-1 text-2xl font-bold text-gray-900">{{ number_format($overview['totalItemsOnHand'], 0) }}</dd>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <dt class="text-xs font-medium text-gray-500 uppercase">Low Stock</dt>
                <dd class="mt-1 text-2xl font-bold text-yellow-600">{{ $overview['lowStockCount'] }}</dd>
            </div>
        </x-card>
        <x-card>
            <div class="text-center">
                <dt class="text-xs font-medium text-gray-500 uppercase">Out of Stock</dt>
                <dd class="mt-1 text-2xl font-bold text-red-600">{{ $overview['outOfStockCount'] }}</dd>
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Stock Cards Table -->
        <x-card title="Stock Cards" description="Current inventory balances" class="lg:col-span-2">
            @php
                $stockCardRows = $stockCards->map(fn ($card) => (object) [
                    'cells' => [
                        new \Illuminate\Support\HtmlString(
                            '<a href="'.e(route('admin.inventory.stock-card', $card->product_id)).'" class="text-blue-600 hover:text-blue-800">'
                            .e($card->product->product_name ?? '-')
                            .'</a>'
                        ),
                        $card->warehouse->warehouse_name ?? '-',
                        number_format($card->quantity_on_hand, 2),
                        number_format($card->quantity_reserved, 2),
                        number_format($card->quantity_available, 2),
                        $card->batch_number ?? '-',
                        $card->expiry_date ? $card->expiry_date->format('Y-m-d') : '-',
                    ],
                ]);
            @endphp
            <x-table
                :headers="['Product', 'Warehouse', 'On Hand', 'Reserved', 'Available', 'Batch #', 'Expiry']"
                :rows="$stockCardRows"
                empty="No stock cards found."
            >
            </x-table>
            <div class="mt-4">
                {{ $stockCards->links() }}
            </div>
        </x-card>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Low Stock Items -->
        <x-card title="Low Stock Items" description="Items below threshold">
            @if($lowStockItems->count() > 0)
                <x-table :headers="['Product', 'Warehouse', 'Available']" :rows="$lowStockItems->map(fn($item) => (object)[
                    'cells' => [
                        $item->product->product_name ?? '-',
                        $item->warehouse->warehouse_name ?? '-',
                        number_format($item->quantity_available, 2),
                    ]
                ])" empty="No low stock items.">
                </x-table>
            @else
                <p class="text-gray-500 text-sm py-4 text-center">No low stock items.</p>
            @endif
        </x-card>

        <!-- Expiring Items -->
        <x-card title="Expiring Items" description="Items expiring within 30 days">
            @if($expiringItems->count() > 0)
                <x-table :headers="['Product', 'Warehouse', 'Qty', 'Expiry']" :rows="$expiringItems->map(fn($item) => (object)[
                    'cells' => [
                        $item->product->product_name ?? '-',
                        $item->warehouse->warehouse_name ?? '-',
                        number_format($item->quantity_on_hand, 2),
                        $item->expiry_date ? $item->expiry_date->format('Y-m-d') : '-',
                    ]
                ])" empty="No expiring items.">
                </x-table>
            @else
                <p class="text-gray-500 text-sm py-4 text-center">No expiring items.</p>
            @endif
        </x-card>
    </div>
</div>
@endsection
