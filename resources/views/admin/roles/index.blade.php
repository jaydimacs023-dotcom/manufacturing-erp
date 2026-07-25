@extends('layouts.app')

@section('page-header', 'Roles')
@section('page-description', 'Manage user roles and permissions')

@section('content')
<div class="mb-6 flex justify-between items-center">
    @can('role-create')
        <x-button variant="primary" href="{{ route('admin.roles.create') }}">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Role
        </x-button>
    @endcan
</div>

<x-card>
    <x-table :headers="['Name', 'Users', 'Permissions', 'Created At', 'Actions']">
        @forelse($roles as $role)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $role->name }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $role->users->count() }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    <div class="flex flex-wrap gap-1">
                        @foreach($role->permissions->take(5) as $permission)
                            <x-badge variant="primary" size="sm">{{ $permission->name }}</x-badge>
                        @endforeach
                        @if($role->permissions->count() > 5)
                            <span class="text-xs text-gray-400">+{{ $role->permissions->count() - 5 }} more</span>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $role->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    @include('admin.roles._actions', ['role' => $role])
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                    <p class="text-lg font-medium mb-2">No roles found</p>
                    <p class="text-sm">Get started by creating your first role.</p>
                    @can('role-create')
                        <x-button variant="primary" href="{{ route('admin.roles.create') }}" class="mt-4">
                            Create Role
                        </x-button>
                    @endcan
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="px-6 py-4 border-t border-gray-200">
        {{ $roles->links() }}
    </div>
</x-card>
@endsection

