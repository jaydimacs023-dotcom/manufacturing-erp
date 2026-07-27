@php
    $user = auth()->user();
    $roleLabel = 'Staff';
    $showDashboard = 'Welcome to the ERP';
    if ($user) {
        if ($user->can('view-administration')) { $roleLabel = 'Administrator'; $showDashboard = 'Admin Dashboard'; }
        elseif ($user->can('procurement-view')) { $roleLabel = 'Procurement'; $showDashboard = 'Procurement Dashboard'; }
        elseif ($user->can('inventory-view')) { $roleLabel = 'Warehouse'; $showDashboard = 'Inventory Dashboard'; }
        elseif ($user->can('manufacturing-order-view')) { $roleLabel = 'Manufacturing'; $showDashboard = 'Manufacturing Dashboard'; }
        else { $roleLabel = 'Staff'; $showDashboard = 'My Dashboard'; }
    }
@endphp

@extends('layouts.app')

@section('title', $showDashboard)

@section('page-header', $showDashboard)
@section('page-description', 'Welcome back, ' . ($user->name ?? 'User') . '. Here\'s your overview.')

@section('content')
<!-- Metric Cards -->
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="metric-card">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-slate-500">Active Products</p>
                <p class="mt-2 font-headline text-2xl font-bold tracking-tight text-slate-900" id="stat-products">—</p>
            </div>
            <span class="rounded-xl bg-emerald-50 p-2.5 text-emerald-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </span>
        </div>
        <p class="mt-3 text-xs font-medium text-slate-500">Products in catalog</p>
    </div>

    <div class="metric-card">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-slate-500">Open Orders</p>
                <p class="mt-2 font-headline text-2xl font-bold tracking-tight text-slate-900" id="stat-orders">—</p>
            </div>
            <span class="rounded-xl bg-blue-50 p-2.5 text-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </span>
        </div>
        <p class="mt-3 text-xs font-medium text-slate-500">Pending transactions</p>
    </div>

    <div class="metric-card">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-slate-500">Inventory Alerts</p>
                <p class="mt-2 font-headline text-2xl font-bold tracking-tight text-slate-900" id="stat-alerts">—</p>
            </div>
            <span class="rounded-xl bg-amber-50 p-2.5 text-amber-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </span>
        </div>
        <p class="mt-3 text-xs font-medium text-slate-500">Low stock items</p>
    </div>

    <div class="metric-card">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-slate-500">Active Users</p>
                <p class="mt-2 font-headline text-2xl font-bold tracking-tight text-slate-900" id="stat-users">—</p>
            </div>
            <span class="rounded-xl bg-violet-50 p-2.5 text-violet-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </span>
        </div>
        <p class="mt-3 text-xs font-medium text-slate-500">Registered in system</p>
    </div>
</div>

<!-- Placeholder sections -->
<div class="mt-5 grid gap-5 xl:grid-cols-[1.6fr_1fr]">
    <div class="section-card">
        <div class="section-header">
            <div>
                <h2 class="font-headline text-base font-bold text-slate-900">Recent Activity</h2>
                <p class="mt-0.5 text-xs text-slate-500">Latest system actions</p>
            </div>
        </div>
        <div class="p-5">
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <p class="text-sm font-medium text-slate-500">Activity feed will appear here</p>
                <p class="text-xs text-slate-400 mt-1">As you use the system, your recent actions will be logged.</p>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-header">
            <div>
                <h2 class="font-headline text-base font-bold text-slate-900">Quick Actions</h2>
                <p class="mt-0.5 text-xs text-slate-500">Common tasks</p>
            </div>
        </div>
        <div class="p-5 space-y-2">
            @can('product-view')
                <a href="{{ route('admin.products.create') }}" class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                    <span class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold text-slate-900">Create Product</span>
                        <span class="mt-1 block text-xs text-slate-500">Add a new product to the catalog</span>
                    </span>
                </a>
            @endcan
            @can('procurement-view')
                <a href="{{ route('admin.purchase-requests.create') }}" class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                    <span class="rounded-xl bg-blue-50 p-3 text-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold text-slate-900">New Purchase Request</span>
                        <span class="mt-1 block text-xs text-slate-500">Request materials or supplies</span>
                    </span>
                </a>
            @endcan
            @can('inventory-view')
                <a href="{{ route('admin.inventory.adjustments.create') }}" class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                    <span class="rounded-xl bg-amber-50 p-3 text-amber-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </span>
                    <span>
                        <span class="block text-sm font-bold text-slate-900">Adjust Inventory</span>
                        <span class="mt-1 block text-xs text-slate-500">Record stock adjustments</span>
                    </span>
                </a>
            @endcan
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch dashboard stats
    fetch('/api/dashboard/stats')
        .then(r => r.json())
        .then(data => {
            if (data.products !== undefined) document.getElementById('stat-products').textContent = data.products.toLocaleString();
            if (data.orders !== undefined) document.getElementById('stat-orders').textContent = data.orders.toLocaleString();
            if (data.alerts !== undefined) document.getElementById('stat-alerts').textContent = data.alerts.toLocaleString();
            if (data.users !== undefined) document.getElementById('stat-users').textContent = data.users.toLocaleString();
        })
        .catch(() => {
            // Silently fail - stats will show "—"
        });
});
</script>
@endpush
