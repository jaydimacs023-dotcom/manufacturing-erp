@extends('layouts.app')

@section('page-header', 'Executive Dashboard')
@section('page-description', 'Cross-domain KPI summary for management')

@section('content')
<div class="space-y-6">
    <!-- Production KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-card title="Production Today" class="text-center">
            <p class="text-3xl font-bold text-blue-600">{{ number_format($production_today, 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">Units produced today</p>
        </x-card>
        <x-card title="Active Orders" class="text-center">
            <p class="text-3xl font-bold text-indigo-600">{{ $active_orders }}</p>
            <p class="text-xs text-gray-500 mt-1">Manufacturing in progress</p>
        </x-card>
        <x-card title="Yield" class="text-center">
            <p class="text-3xl font-bold text-green-600">{{ $yield_percentage }}%</p>
            <p class="text-xs text-gray-500 mt-1">Production yield rate</p>
        </x-card>
        <x-card title="Waste" class="text-center">
            <p class="text-3xl font-bold text-red-600">{{ $waste_percentage }}%</p>
            <p class="text-xs text-gray-500 mt-1">Waste percentage</p>
        </x-card>
    </div>

    <!-- Sales KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-card title="Sales Orders Today" class="text-center">
            <p class="text-3xl font-bold text-emerald-600">{{ $sales_orders_today }}</p>
            <p class="text-xs text-gray-500 mt-1">New orders today</p>
        </x-card>
        <x-card title="Open Orders" class="text-center">
            <p class="text-3xl font-bold text-amber-600">{{ $open_sales_orders }}</p>
            <p class="text-xs text-gray-500 mt-1">Awaiting fulfillment</p>
        </x-card>
        <x-card title="Pending Exports" class="text-center">
            <p class="text-3xl font-bold text-purple-600">{{ $pending_exports }}</p>
            <p class="text-xs text-gray-500 mt-1">Export orders not shipped</p>
        </x-card>
        <x-card title="Pending Dispatches" class="text-center">
            <p class="text-3xl font-bold text-orange-600">{{ $pending_dispatches }}</p>
            <p class="text-xs text-gray-500 mt-1">Awaiting dispatch</p>
        </x-card>
    </div>

    <!-- Inventory & Procurement KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-card title="Low Stock Items" class="text-center">
            <p class="text-3xl font-bold text-red-600">{{ $low_stock_count }}</p>
            <p class="text-xs text-gray-500 mt-1">Below minimum stock</p>
        </x-card>
        <x-card title="Active Reservations" class="text-center">
            <p class="text-3xl font-bold text-cyan-600">{{ $active_reservations }}</p>
            <p class="text-xs text-gray-500 mt-1">Reserved inventory</p>
        </x-card>
        <x-card title="Pending PR" class="text-center">
            <p class="text-3xl font-bold text-slate-600">{{ $pending_purchase_requests }}</p>
            <p class="text-xs text-gray-500 mt-1">Purchase requests</p>
        </x-card>
        <x-card title="Pending PO" class="text-center">
            <p class="text-3xl font-bold text-slate-600">{{ $pending_purchase_orders }}</p>
            <p class="text-xs text-gray-500 mt-1">Purchase orders</p>
        </x-card>
    </div>

    <!-- Quality & Accounting KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-card title="Failed Inspections" class="text-center">
            <p class="text-3xl font-bold text-red-600">{{ $failed_inspections }}</p>
            <p class="text-xs text-gray-500 mt-1">Total rejected</p>
        </x-card>
        <x-card title="Open NCs" class="text-center">
            <p class="text-3xl font-bold text-amber-600">{{ $open_non_conformances }}</p>
            <p class="text-xs text-gray-500 mt-1">Non-conformances</p>
        </x-card>
        <x-card title="Pending Events" class="text-center">
            <p class="text-3xl font-bold text-yellow-600">{{ $pending_accounting_events }}</p>
            <p class="text-xs text-gray-500 mt-1">Accounting events</p>
        </x-card>
        <x-card title="Report Generated" class="text-center">
            <p class="text-3xl font-bold text-gray-600">{{ now()->format('H:i') }}</p>
            <p class="text-xs text-gray-500 mt-1">{{ now()->format('Y-m-d') }}</p>
        </x-card>
    </div>
</div>
@endsection
