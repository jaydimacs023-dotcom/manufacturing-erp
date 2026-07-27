@extends('layouts.app')

@section('page-header', 'Manufacturing Reports')
@section('page-description', 'Production performance and analysis')

@section('content')
<div class="space-y-6">
    @include('admin.reports._filters', ['route' => route('admin.reports.manufacturing')])

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-stat-card label="Total Orders" :value="$total_orders" icon="clipboard-list" color="blue" />
        <x-stat-card label="Active Orders" :value="$active_orders" icon="play" color="green" />
        <x-stat-card label="Completed" :value="$completed_orders" icon="check-circle" color="green" />
        <x-stat-card label="Yield %" :value="$yield_percentage . '%'" icon="trending-up" color="blue" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-stat-card label="Total Output" :value="number_format($total_output, 0)" icon="package" color="green" />
        <x-stat-card label="Total Waste" :value="number_format($total_waste, 0)" icon="trash" color="red" />
        <x-stat-card label="Waste %" :value="$waste_percentage . '%'" icon="trending-down" color="red" />
    </div>

    <x-card title="Manufacturing Orders" description="Recent orders">
        <x-table :headers="['Order #', 'Product', 'Status', 'Created']" :rows="collect($orders)->map(fn($o) => (object)[
            'cells' => [$o->manufacturing_order_number ?? $o->id, $o->product?->product_name ?? '-', ucfirst($o->status ?? 'N/A'), $o->created_at->format('Y-m-d')]
        ])" empty="No manufacturing orders found." />
    </x-card>

    <x-card title="Recent Production Outputs" description="Latest production records">
        <x-table :headers="['MO #', 'Product', 'Qty', 'Date']" :rows="collect($recent_outputs)->map(fn($o) => (object)[
            'cells' => [$o->manufacturingOrder?->manufacturing_order_number ?? '-', $o->product?->product_name ?? '-', number_format($o->quantity, 0), $o->created_at->format('Y-m-d')]
        ])" empty="No production outputs recorded." />
    </x-card>
</div>
@endsection

