@extends('layouts.app')

@section('page-header', 'Inventory Report')
@section('page-description', 'Stock cards, movements, and valuation summary')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-stat label="Total Movements" :value="$total_movements" color="blue" />
        <x-stat label="Today's Movements" :value="$today_movements" color="green" />
        <x-stat label="Pending Adjustments" :value="$pending_adjustments" color="yellow" />
        <x-stat label="Low Stock Products" :value="$low_stock_products" color="red" />
    </div>

    <!-- Filters -->
    <x-card title="Filters">
        @include('admin.reports._filters', ['route' => route('admin.reports.inventory'), 'showStatus' => false])
    </x-card>

    <!-- Recent Movements -->
    <x-card title="Recent Inventory Movements">
        <x-table :headers="['Product', 'Type', 'Warehouse', 'Qty', 'Date']" :rows="$recent_movements->map(fn($m) => (object)[
            'cells' => [
                $m->product?->product_name ?? '-',
                ucfirst($m->movement_type),
                $m->warehouse?->warehouse_name ?? '-',
                number_format($m->quantity, 2),
                $m->created_at->format('Y-m-d H:i'),
            ]
        ])" empty="No movements found." />
    </x-card>

    <!-- Stock Cards -->
    <x-card title="Stock Card Summary (Lowest First)">
        <x-table :headers="['Product', 'SKU', 'Current Stock', 'Min Stock']" :rows="$stock_cards->map(fn($sc) => (object)[
            'cells' => [
                $sc->product?->product_name ?? '-',
                $sc->product?->sku ?? '-',
                number_format($sc->quantity
