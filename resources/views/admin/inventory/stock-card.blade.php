@extends('layouts.app')

@section('page-header', $product->product_name ?? 'Stock Card')
@section('page-description', 'Inventory movement history and balance')

@section('content')
<div class="space-y-6">
    <!-- Product Summary -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @foreach($stockCards as $card)
        <x-card>
            <div class="text-center">
                <dt class="text-xs font-medium text-gray-500 uppercase">{{ $card->warehouse->warehouse_name ?? 'N/A' }}</dt>
                <dd class="mt-1 text-lg font-bold text-gray-900">{{ number_format($card->quantity_on_hand, 2) }}</dd>
                <dd class="text-xs text-gray-500">On Hand</dd>
                <dd class="text-sm font-medium {{ $card->quantity_available > 0 ? 'text-green-600' : 'text-red-600' }}">
                    {{ number_format($card->quantity_available, 2) }} Available
                </dd>
                @if($card->batch_number)
                <dd class="text-xs text-gray-400 mt-1">Batch: {{ $card->batch_number }}</dd>
                @endif
                @if($card->expiry_date)
                <dd class="text-xs text-gray-400">Exp: {{ $card->expiry_date->format('Y-m-d') }}</dd>
                @endif
            </div>
        </x-card>
        @endforeach
    </div>

    <!-- Movements Table -->
    <x-card title="Movement History" description="All inventory movements for this product">
        @if($movements->count() > 0)
            <x-table :headers="['Date', 'Movement #', 'Type', 'Warehouse', 'Qty', 'Unit Cost', 'Total', 'Batch #', 'Reference']" :rows="$movements->map(fn($m) => (object)[
                'cells' => [
                    $m->created_at->format('Y-m-d H:i'),
                    $m->movement_number,
                    '<span class="px-2 py-1 text-xs rounded-full '.($m->quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800').'">'.ucwords(str_replace('_', ' ', $m->movement_type)).'</span>',
                    $m->warehouse->warehouse_name ?? '-',
                    number_format($m->quantity, 4),
                    number_format($m->unit_cost, 2),
                    number_format($m->total_cost, 2),
                    $m->batch_number ?? '-',
                    $m->reference_type ? ucwords(str_replace('_', ' ', $m->reference_type)).' #'.$m->reference_id : '-',
                ]
            ])" empty="No movements recorded.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No movements recorded for this product.</p>
        @endif
    </x-card>

    <div class="flex items-center space-x-3">
        <x-button variant="secondary" href="{{ route('admin.inventory.index') }}">Back to Inventory</x-button>
    </div>
</div>
@endsection

