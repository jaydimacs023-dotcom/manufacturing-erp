@extends('layouts.app')

@section('page-header', 'Sales & Export Reports')
@section('page-description', 'Sales orders, exports, and customer analysis')

@section('content')
<div class="space-y-6">
    @include('admin.reports._filters', ['route' => route('admin.reports.sales')])

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-stat-card label="Total Sales Orders" :value="$total_sales_orders" icon="shopping-cart" color="blue" />
        <x-stat-card label="Open Orders" :value="$open_orders" icon="clock" color="yellow" />
        <x-stat-card label="Shipped Orders" :value="$shipped_orders" icon="check-circle" color="green" />
        <x-stat-card label="Total Export Orders" :value="$total_export_orders" icon="globe" color="blue" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        <x-stat-card label="Pending Exports" :value="$pending_exports" icon="clock" color="yellow" />
    </div>

    <x-card title="Sales Orders" description="Recent sales orders">
        <x-table :headers="['SO #', 'Customer', 'Status', 'Date']" :rows="collect($sales_orders)->map(fn($so) => (object)[
            'cells' => [$so->sales_order_number ?? '-', $so->customer?->partner_name ?? '-', ucfirst($so->status ?? 'N/A'), $so->created_at->format('Y-m-d')]
        ])" empty="No sales orders found." />
    </x-card>

    <x-card title="Export Orders" description="Recent export orders">
        <x-table :headers="['EO #', 'Customer', 'Country', 'Status']" :rows="collect($export_orders)->map(fn($eo) => (object)[
            'cells' => [$eo->export_order_number ?? '-', $eo->customer?->partner_name ?? '-', $eo->destination_country ?? '-', ucfirst($eo->status ?? 'N/A')]
        ])" empty="No export orders found." />
    </x-card>
</div>
@endsection

