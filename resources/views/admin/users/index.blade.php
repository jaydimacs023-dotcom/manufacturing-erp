@extends('layouts.app')

@section('page-header', 'Users')
@section('page-description', 'Manage system users')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <x-input type="search" placeholder="Search users..." />
    </div>
    @can('user-create')
        <x-button variant="primary" href="{{ route('admin.users.create') }}">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New User
        </x-button>
    @endcan
</div>

<x-card>
    <x-table :headers="['Name', 'Email', 'Branch', 'Department', 'Status', 'Last Login', 'Actions']">
        @forelse($users as $user)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-sm font-medium text-gray-600">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $user->email }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $user->branch?->branch_name ?? '—' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $user->department?->department_name ?? '—' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center space-x-2">
                        <x-badge :variant="$user->is_active ? 'success' : 'danger'">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </x-badge>
                        @if($user->is_locked)
                            <x-badge variant="danger">Locked</x-badge>
                        @endif
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center space-x-2">
                        @can('user-update')
                            <x-button variant="secondary" size="sm" href="{{ route('admin.users.edit', $user) }}">
                                Edit
                            </x-button>
                        @endcan
                        @can('user-delete')
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this user?')">
                                @csrf
                                @method('DELETE')
                                <x-button variant="danger" size="sm" type="submit">
                                    Delete
                                </x-button>
                            </form>
                        @endcan
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                    <p class="text-lg font-medium mb-2">No users found</p>
                    <p class="text-sm">Get started by creating your first user.</p>
                    @can('user-create')
                        <x-button variant="primary" href="{{ route('admin.users.create') }}" class="mt-4">
                            Create User
                        </x-button>
                    @endcan
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="px-6 py-4 border-t border-gray-200">
        {{ $users->links() }}
    </div>
</x-card>
@endsection

