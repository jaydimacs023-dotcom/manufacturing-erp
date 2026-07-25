@extends('layouts.app')

@section('page-header', 'Branches')
@section('page-description', 'Manage branch locations')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search branches..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        @can('branch-create')
            <x-button variant="primary" href="{{ route('admin.branches.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Branch
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Code', 'Name', 'Contact', 'Status', 'Created At', 'Actions']" :rows="$branches->map(fn($b) => (object)[
        'cells' => [
            $b->branch_code,
            $b->branch_name,
            $b->contact_number ?? '-',
            view('components.badge', ['status' => $b->is_active ? 'active' : 'inactive'])->with('slot', $b->is_active ? 'Active' : 'Inactive'),
            $b->created_at->format('Y-m-d'),
            view('admin.branches._actions', ['branch' => $b])->render(),
        ]
    ])" empty="No branches found." actionLabel="New Branch" actionRoute="{{ route('admin.branches.create') }}">
        @foreach($branches as $branch)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $branch->branch_code }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $branch->branch_name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $branch->contact_number ?? '-' }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-badge :status="$branch->is_active ? 'active' : 'inactive'">
                        {{ $branch->is_active ? 'Active' : 'Inactive' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $branch->created_at->format('Y-m-d') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                    @include('admin.branches._actions', ['branch' => $branch])
                </td>
            </tr>
        @endforeach
    </x-table>

    <div class="mt-4">
        {{ $branches->links() }}
    </div>
</div>
@endsection

