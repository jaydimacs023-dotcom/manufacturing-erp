@extends('layouts.app')

@section('page-header', 'Procurement Report')
@section('page-description', 'Purchase requests, orders, and supplier summary')

@section('content')
<div class="space-y-6">
    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-stat label="Total Purchase Requests" :value="$total_purchase_requests" color="blue" />
        <x-stat label="Pending" :value="$pending_requests" color="yellow" />
        <x-stat label="Approved" :value="$approved_requests" color="green" />
        <x-stat label="Total Purchase Orders" :value="$total_purchase_orders" color="indigo" />
    </div>

    <!-- Filters -->
    <x-card title="Filters">
        @include('admin.reports._filters', ['route' => route('admin.reports.procurement')])
    </x-card>

    <!-- Purchase Requests Table -->
    <x-card title="Recent Purchase Requests">
        <x-table :headers="['#', 'Requested By', 'Status', 'Date']" :rows="$purchase_requests->map(fn($pr) => (object)[
            'cells' => [
                $pr->pr_number ?? $pr->id,
                $pr->requestedBy?->name ?? '-',
                view('components.badge', ['status' => $pr->status === 'approved' ? 'active' : ($pr->status === 'cancelled' ? 'inactive' : 'info')])->with('slot', ucfirst($pr->status))->render(),
                $pr->created_at->format('Y-m-d'),
            ]
        ])" empty="No purchase requests found." />
    </x-card>

    <!-- Purchase Orders Table -->
    <x-card title="Recent Purchase Orders">
        <x-table :headers="['#', 'Supplier', 'Status', 'Date']" :rows="$purchase_orders->map(fn($po) => (object)[
            'cells' => [
                $po->po_number ?? $po->id,
                $po->supplier?->name ?? '-',
                view('components.badge', ['status' => $po->status === 'approved' ? 'active' : ($po->status === 'cancelled' ? 'inactive' : 'info')])->with('slot', ucfirst($po->status))->render(),
                $po->created_at->format('Y-m-d'),
            ]
        ])" empty="No purchase orders found." />
    </x-card>

    <div class="flex items-center justify-end">
        <x-button variant="secondary" href="{{ route('admin.reports.index') }}">Back to Reports</x-button>
    </div>
</div>
@endsection

