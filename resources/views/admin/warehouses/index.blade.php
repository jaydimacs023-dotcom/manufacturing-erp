@extends('layouts.app')

@section('page-header', 'Warehouses')
@section('page-description', 'Manage storage facilities')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <p class="text-sm text-gray-600">Manage all warehouses and storage locations across branches.</p>
    </div>
    @can('warehouse-create')
        <x-button variant="primary" href="{{ route('admin.warehouses.create') }}">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            New Warehouse
        </x-button>
    @endcan
</div>

<x-card>
    <x-table :headers="['Code', 'Name', 'Type', 'Branch', 'Status', 'Actions']">
        <x-slot:body>
            @forelse($warehouses as $warehouse)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                        {{ $warehouse->warehouse_code ?? '—' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $warehouse->warehouse_name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-badge variant="secondary" size="sm">
                            {{ str_replace('_', ' ', ucwords($warehouse->warehouse_type ?? 'general')) }}
                        </x-badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $warehouse->branch?->branch_name ?? '—' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-badge :variant="$warehouse->is_active ? 'success' : 'danger'" size="sm">
                            {{ $warehouse->is_active ? 'Active' : 'Inactive' }}
                        </x-badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <div class="flex items-center space-x-2">
                            @can('warehouse-update')
                                <a href="{{ route('admin.warehouses.edit', $warehouse) }}" class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                            @endcan
                            @can('warehouse-delete')
                                <form action="{{ route('admin.warehouses.destroy', $warehouse) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this warehouse?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                            <p class="text-gray-500 text-sm">No warehouses found.</p>
                            @can('warehouse-create')
                                <x-button variant="primary" href="{{ route('admin.warehouses.create') }}" class="mt-4">
                                    Create Warehouse
                                </x-button>
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-slot:body>
    </x-table>

    @if($warehouses->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $warehouses->links() }}
        </div>
    @endif
</x-card>
@endsection

