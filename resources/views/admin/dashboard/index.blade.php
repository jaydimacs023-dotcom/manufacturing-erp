@extends('layouts.app')

@section('page-header', 'Administration Dashboard')
@section('page-description', 'System overview and statistics')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Users -->
    <x-card title="Total Users" description="Registered users">
        <div class="text-center py-4">
            <p class="text-3xl font-bold text-blue-600">{{ $totalUsers }}</p>
            <p class="text-sm text-gray-500 mt-1">
                {{ $activeUsers }} active · {{ $lockedAccounts }} locked
            </p>
        </div>
    </x-card>

    <!-- Branches -->
    <x-card title="Branches" description="Active branches">
        <div class="text-center py-4">
            <p class="text-3xl font-bold text-green-600">{{ $branchCount }}</p>
            <p class="text-sm text-gray-500 mt-1">Operational locations</p>
        </div>
    </x-card>

    <!-- Warehouses -->
    <x-card title="Warehouses" description="Storage facilities">
        <div class="text-center py-4">
            <p class="text-3xl font-bold text-amber-600">{{ $warehouseCount }}</p>
            <p class="text-sm text-gray-500 mt-1">Across all branches</p>
        </div>
    </x-card>

    <!-- Departments -->
    <x-card title="Departments" description="Organizational units">
        <div class="text-center py-4">
            <p class="text-3xl font-bold text-purple-600">{{ $departmentCount }}</p>
            <p class="text-sm text-gray-500 mt-1">Departments</p>
        </div>
    </x-card>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Logins -->
    <x-card title="Recent Logins" description="Latest user login activity">
        @if($recentLogins->count() > 0)
            <div class="space-y-3">
                @foreach($recentLogins as $login)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-medium text-gray-600">
                                {{ substr($login->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $login->name }}</p>
                                <p class="text-xs text-gray-500">{{ $login->email }}</p>
                            </div>
                        </div>
                        <span class="text-xs text-gray-400">
                            {{ $login->last_login_at ? $login->last_login_at->diffForHumans() : 'Never' }}
                        </span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No login activity yet.</p>
        @endif
    </x-card>

    <!-- Quick Actions -->
    <x-card title="Quick Actions" description="Common administration tasks">
        <div class="space-y-2">
            <x-button variant="primary" href="{{ route('admin.users.create') }}" class="w-full justify-start">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                Create New User
            </x-button>
            <x-button variant="secondary" href="{{ route('admin.branches.create') }}" class="w-full justify-start">
                Add New Branch
            </x-button>
            <x-button variant="secondary" href="{{ route('admin.warehouses.create') }}" class="w-full justify-start">
                Add New Warehouse
            </x-button>
        </div>
    </x-card>
</div>
@endsection

