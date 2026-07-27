@extends('layouts.app')

@section('page-header', 'Corrective Actions')
@section('page-description', 'Manage corrective actions for quality issues')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search actions..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.quality-control.corrective-actions.index') }}">All Status</option>
                <option value="{{ route('admin.quality-control.corrective-actions.index', ['status' => 'open']) }}" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                <option value="{{ route('admin.quality-control.corrective-actions.index', ['status' => 'in_progress']) }}" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="{{ route('admin.quality-control.corrective-actions.index', ['status' => 'completed']) }}" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="{{ route('admin.quality-control.corrective-actions.index', ['status' => 'closed']) }}" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            @can('corrective-action-create')
                <x-button variant="primary" href="{{ route('admin.quality-control.corrective-actions.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Corrective Action
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['Action #', 'Inspection', 'Type', 'Status', 'Due Date', 'Actions']" :rows="$actions->map(fn($ca) => (object)[
        'cells' => [
            $ca->action_number,
            $ca->inspection->inspection_number ?? '-',
            ucwords(str_replace('_', ' ', $ca->action_type)),
            view('components.badge', ['status' => $ca->status === 'closed' ? 'active' : ($ca->status === 'open' ? 'inactive' : 'info')])->with('slot', ucwords(str_replace('_', ' ', $ca->status))),
            $ca->due_date ? $ca->due_date->format('Y-m-d') : '-',
            view('admin.quality-control.corrective-actions._actions', ['ca' => $ca])->render(),
        ]
    ])" empty="No corrective actions found." actionLabel="New Corrective Action" actionRoute="{{ route('admin.quality-control.corrective-actions.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $actions->links() }}
    </div>
</div>
@endsection

