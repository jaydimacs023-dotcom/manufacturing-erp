@extends('layouts.app')

@section('page-header', 'Units of Measure')
@section('page-description', 'Manage units of measure')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search UOMs..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        @can('uom-create')
            <x-button variant="primary" href="{{ route('admin.units-of-measure.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New UOM
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Code', 'Name', 'Type', 'Status', 'Created At', 'Actions']" :rows="$unitsOfMeasure->map(fn($u) => (object)[
        'cells' => [
            $u->uom_code,
            $u->uom_name,
            $u->uom_type,
            view('components.badge', ['status' => $u->is_active ? 'active' : 'inactive'])->with('slot', $u->is_active ? 'Active' : 'Inactive'),
            $u->created_at->format('Y-m-d'),
            view('admin.units-of-measure._actions', ['unit' => $u])->render(),
        ]
    ])" empty="No units of measure found." actionLabel="New UOM" actionRoute="{{ route('admin.units-of-measure.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $unitsOfMeasure->links() }}
    </div>
</div>
@endsection

