@extends('layouts.app')

@section('page-header', 'Departments')
@section('page-description', 'Manage organizational departments')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <x-search-input
            placeholder="Search departments..."
            wire:model.live="search"
        />
    </div>
    @can('department-create')
        <x-button variant="primary" href="{{ route('admin.departments.create') }}">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Department
        </x-button>
    @endcan
</div>

<x-card>
    <x-table :headers="['Code', 'Name', 'Description', 'Status', 'Created At', 'Actions']">
        @forelse($departments as $department)
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    {{ $department->department_code ?? '—' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    {{ $department->department_name }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                    {{ $department->description ?? '—' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-badge :variant="$department->is_active ? 'success' : 'danger'">
                        {{ $department->is_active ? 'Active' : 'Inactive' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                    {{ $department->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    @include('admin.departments._actions', ['department' => $department])
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                    <p class="text-lg font-medium mb-2">No departments found</p>
                    <p class="text-sm">Get started by creating your first department.</p>
                    @can('department-create')
                        <x-button variant="primary" href="{{ route('admin.departments.create') }}" class="mt-4">
                            Create Department
                        </x-button>
                    @endcan
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="px-6 py-4 border-t border-gray-200">
        {{ $departments->links() }}
    </div>
</x-card>
@endsection

