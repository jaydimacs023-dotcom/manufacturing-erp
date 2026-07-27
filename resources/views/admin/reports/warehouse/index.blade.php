@extends('layouts.app')

@section('page-header', 'Warehouse Reports')
@section('page-description', 'Warehouse operations and activity')

@section('content')
<div class="space-y-6">
    @include('admin.reports._filters', ['route' => route('admin.reports.warehouse')])

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-stat-card label="Total Put-away" :value="$total_putaway" icon="archive" color="blue" />
        <x-stat-card label="Pending Put-away" :value="$pending_putaway" icon="clock" color="yellow" />
        <x-stat-card label="Total Picking" :value="$total_picking" icon="package" color="blue" />
        <x-stat-card label="Pending Picking" :value="$pending_picking" icon="clock" color="yellow" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-stat-card label="Total Dispatch" :value="$total_dispatch" icon="truck" color="blue" />
        <x-stat-card label="Pending Dispatch" :value="$pending_dispatch" icon="clock" color="yellow" />
        <x-stat-card label="Dispatches Today" :value="$dispatches_today" icon="check-circle" color="green" />
    </div>

    <x-card title="Recent Dispatches" description="Latest dispatch activity">
        <x-table :headers="['Dispatch #', 'Product', 'Warehouse', 'Date']" :rows="collect($recent_dispatches)->map(fn($d) => (object)[
            'cells' => [$d->dispatch_number ?? '-', $d->product?->product_name ?? '-', $d->warehouse?->warehouse_name ?? '-', $d->created_at->format('Y-m-d')]
        ])" empty="No dispatch records found." />
    </x-card>
</div>
@endsection

