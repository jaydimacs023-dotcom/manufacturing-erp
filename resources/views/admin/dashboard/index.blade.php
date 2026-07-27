@php
    $user = auth()->user();
@endphp

@extends('layouts.app')

@section('title', 'Administration Dashboard')

@section('page-header', 'Administration Dashboard')
@section('page-description', 'System overview and statistics')

@section('content')
<!-- Metric Cards -->
<div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="metric-card">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-slate-500">Total Users</p>
                <p class="mt-2 font-headline text-2xl font-bold tracking-tight text-slate-900">{{ $totalUsers }}</p>
            </div>
            <span class="rounded-xl bg-emerald-50 p-2.5 text-emerald-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </span>
        </div>
        <p class="mt-3 text-xs font-medium text-slate-500">{{ $activeUsers }} active · {{ $lockedAccounts }} locked</p>
    </div>

    <div class="metric-card">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-slate-500">Branches</p>
                <p class="mt-2 font-headline text-2xl font-bold tracking-tight text-slate-900">{{ $branchCount }}</p>
            </div>
            <span class="rounded-xl bg-blue-50 p-2.5 text-blue-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </span>
        </div>
        <p class="mt-3 text-xs font-medium text-slate-500">Operational locations</p>
    </div>

    <div class="metric-card">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-slate-500">Warehouses</p>
                <p class="mt-2 font-headline text-2xl font-bold tracking-tight text-slate-900">{{ $warehouseCount }}</p>
            </div>
            <span class="rounded-xl bg-amber-50 p-2.5 text-amber-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </span>
        </div>
        <p class="mt-3 text-xs font-medium text-slate-500">Across all branches</p>
    </div>

    <div class="metric-card">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-sm font-medium text-slate-500">Departments</p>
                <p class="mt-2 font-headline text-2xl font-bold tracking-tight text-slate-900">{{ $departmentCount }}</p>
            </div>
            <span class="rounded-xl bg-violet-50 p-2.5 text-violet-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </span>
        </div>
        <p class="mt-3 text-xs font-medium text-slate-500">Organizational units</p>
    </div>
</div>

<div class="mt-5 grid gap-5 xl:grid-cols-[1.6fr_1fr]">
    <!-- Recent Logins -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h2 class="font-headline text-base font-bold text-slate-900">Recent Logins</h2>
                <p class="mt-0.5 text-xs text-slate-500">Latest user login activity</p>
            </div>
        </div>
        <div class="p-5">
            @if($recentLogins->count() > 0)
                <div class="space-y-3">
                    @foreach($recentLogins as $login)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div class="flex items-center gap-3">
                                <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-100 text-xs font-bold text-emerald-800">
                                    {{ substr($login->name, 0, 1) }}
                                </span>
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">{{ $login->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $login->email }}</p>
                                </div>
                            </div>
                            <span class="text-xs text-slate-400">
                                {{ $login->last_login_at ? $login->last_login_at->diffForHumans() : 'Never' }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-medium text-slate-500">No login activity yet</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="section-card">
        <div class="section-header">
            <div>
                <h2 class="font-headline text-base font-bold text-slate-900">Quick Actions</h2>
                <p class="mt-0.5 text-xs text-slate-500">Common administration tasks</p>
            </div>
        </div>
        <div class="p-5 space-y-2">
            <a href="{{ route('admin.users.create') }}" class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                <span class="rounded-xl bg-emerald-50 p-3 text-emerald-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </span>
                <span>
                    <span class="block text-sm font-bold text-slate-900">Create New User</span>
                    <span class="mt-1 block text-xs text-slate-500">Add a new system user</span>
                </span>
            </a>
            <a href="{{ route('admin.branches.create') }}" class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                <span class="rounded-xl bg-blue-50 p-3 text-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                </span>
                <span>
                    <span class="block text-sm font-bold text-slate-900">Add New Branch</span>
                    <span class="mt-1 block text-xs text-slate-500">Create a new branch location</span>
                </span>
            </a>
            <a href="{{ route('admin.warehouses.create') }}" class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 text-left transition hover:-translate-y-0.5 hover:border-emerald-300 hover:shadow-md">
                <span class="rounded-xl bg-amber-50 p-3 text-amber-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </span>
                <span>
                    <span class="block text-sm font-bold text-slate-900">Add New Warehouse</span>
                    <span class="mt-1 block text-xs text-slate-500">Register a storage facility</span>
                </span>
            </a>
        </div>
    </div>
</div>
@endsection
