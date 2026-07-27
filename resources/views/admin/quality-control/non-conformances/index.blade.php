@extends('layouts.app')

@section('page-header', 'Non-Conformances')
@section('page-description', 'Track quality defects and non-conformances')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search non-conformances..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.quality-control.non-conformances.index') }}">All Status</option>
                <option value="{{ route('admin.quality-control.non-conformances.index', ['status' => 'open']) }}" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                <option value="{{ route('admin.quality-control.non-conformances.index', ['status' => 'in_progress']) }}" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="{{ route('admin.quality-control.non-conformances.index', ['status' => 'resolved']) }}" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                <option value="{{ route('admin.quality-control.non-conformances.index', ['status' => 'closed']) }}" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
            @can('non-conformance-create')
                <x-button variant="primary" href="{{ route('admin.quality-control.non-conformances.create', ['quality_inspection_id' => request('quality_inspection_id')]) }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Record Non-Conformance
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['NC #', 'Inspection', 'Defect Type', 'Severity', 'Qty Affected', 'Status', 'Actions']" :rows="$nonConformances->map(fn($nc) => (object)[
        'cells' => [
            $nc->nc_number,
            $nc->inspection->inspection_number ?? '-',
            $nc->defectType->name ?? $nc->defect_type,
            view('components.badge', ['status' => $nc->severity === 'critical' ? 'inactive' : ($nc->severity === 'major' ? 'warning' : 'info')])->with('slot', ucfirst($nc->severity)),
            number_format($nc->quantity_affected, 0),
            view('components.badge', ['status' => $nc->status === 'closed' ? 'active' : ($nc->status === 'open' ? 'inactive' : 'info')])->with('slot', ucwords(str_replace('_', ' ', $nc->status))),
            view('admin.quality-control.non-conformances._actions', ['nc' => $nc])->render(),
        ]
    ])" empty="No non-conformances recorded." actionLabel="Record Non-Conformance" actionRoute="{{ route('admin.quality-control.non-conformances.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $nonConformances->links() }}
    </div>
</div>
@endsection

