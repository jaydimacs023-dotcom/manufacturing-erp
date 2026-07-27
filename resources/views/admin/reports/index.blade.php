@extends('layouts.app')

@section('page-header', 'Reports & Analytics')
@section('page-description', 'Operational and management reports across all business domains')

@section('content')
<div class="space-y-6">
    <!-- Executive Dashboard -->
    @can('dashboard-view')
    <x-card title="Executive Dashboard" description="High-level business performance summary">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('admin.reports.executive') }}" class="block p-4 bg-blue-50 rounded-lg border border-blue-200 hover:bg-blue-100 transition-colors">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-blue-700">Executive Summary</span>
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <p class="text-xs text-blue-600 mt-1">Production, sales, inventory KPIs</p>
            </a>
        </div>
    </x-card>
    @endcan

    <!-- Procurement Reports -->
    @can('procurement-view')
    <x-card title="Procurement" description="Purchase requests, orders, and supplier reports">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.reports.procurement') }}" class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all">
                <h4 class="font-medium text-gray-900">Procurement Summary</h4>
                <p class="text-sm text-gray-500 mt-1">PR & PO registers, supplier performance</p>
            </a>
        </div>
    </x-card>
    @endcan

    <!-- Inventory Reports -->
    @can('inventory-view')
    <x-card title="Inventory" description="Stock cards, valuation, and movement reports">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.reports.inventory') }}" class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all">
                <h4 class="font-medium text-gray-900">Inventory Summary</h4>
                <p class="text-sm text-gray-500 mt-1">Stock levels, movements, adjustments</p>
            </a>
        </div>
    </x-card>
    @endcan

    <!-- Manufacturing Reports -->
    @can('manufacturing-order-view')
    <x-card title="Manufacturing" description="Production orders, yield, and waste reports">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.reports.manufacturing') }}" class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all">
                <h4 class="font-medium text-gray-900">Manufacturing Summary</h4>
                <p class="text-sm text-gray-500 mt-1">MO register, yield analysis, waste analysis</p>
            </a>
        </div>
    </x-card>
    @endcan

    <!-- Quality Control Reports -->
    @can('inspection-view')
    <x-card title="Quality Control" description="Inspection and non-conformance reports">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.reports.quality') }}" class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all">
                <h4 class="font-medium text-gray-900">Quality Summary</h4>
                <p class="text-sm text-gray-500 mt-1">Inspection summary, defect analysis</p>
            </a>
        </div>
    </x-card>
    @endcan

    <!-- Warehouse Reports -->
    @can('putaway-view')
    <x-card title="Warehouse" description="Put-away, picking, and dispatch reports">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.reports.warehouse') }}" class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all">
                <h4 class="font-medium text-gray-900">Warehouse Summary</h4>
                <p class="text-sm text-gray-500 mt-1">Activity, dispatch, utilization</p>
            </a>
        </div>
    </x-card>
    @endcan

    <!-- Sales & Export Reports -->
    @can('sales-order-view')
    <x-card title="Sales & Export" description="Sales orders, export, and customer reports">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.reports.sales') }}" class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all">
                <h4 class="font-medium text-gray-900">Sales & Export Summary</h4>
                <p class="text-sm text-gray-500 mt-1">Sales register, export register, customer sales</p>
            </a>
        </div>
    </x-card>
    @endcan

    <!-- Accounting Reports -->
    @can('accounting-event-view')
    <x-card title="Accounting" description="Accounting events and posting reports">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.reports.accounting') }}" class="block p-4 bg-white rounded-lg border border-gray-200 hover:border-blue-300 hover:shadow-sm transition-all">
                <h4 class="font-medium text-gray-900">Accounting Summary</h4>
                <p class="text-sm text-gray-500 mt-1">Event register, posting queue, failed postings</p>
            </a>
        </div>
    </x-card>
    @endcan
</div>
@endsection

