@extends('layouts.app')

@section('page-header', 'User Details')
@section('page-description', $user->name)

@section('content')
<div class="max-w-3xl mx-auto">
    <x-card>
        <div class="flex items-center space-x-4 mb-6 pb-6 border-b border-gray-200">
            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                <span class="text-2xl font-bold text-blue-600">
                    {{ substr($user->name, 0, 1) }}
                </span>
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
            <div class="ml-auto">
                <x-badge :variant="$user->is_active ? 'success' : 'danger'">
                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                </x-badge>
            </div>
        </div>

        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <dt class="text-sm font-medium text-gray-500">Branch</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $user->branch?->branch_name ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Department</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $user->department?->department_name ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Roles</dt>
                <dd class="mt-1">
                    @foreach($user->roles as $role)
                        <x-badge variant="primary">{{ $role->name }}</x-badge>
                    @endforeach
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Last Login</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    {{ $user->last_login_at ? $user->last_login_at->format('M d, Y H:i') : 'Never' }}
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y H:i') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('M d, Y H:i') }}</dd>
            </div>
        </dl>

        <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
            <x-button variant="secondary" href="{{ route('admin.users.index') }}">
                Back to List
            </x-button>
            @can('update', $user)
                <x-button variant="primary" href="{{ route('admin.users.edit', $user) }}">
                    Edit User
                </x-button>
            @endcan
        </div>
    </x-card>
</div>
@endsection

