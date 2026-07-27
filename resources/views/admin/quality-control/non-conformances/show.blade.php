@extends('layouts.app')

@section('page-header', $nonConformance->nc_number)
@section('page-description', 'Non-conformance details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Non-Conformance Information" description="Basic details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">NC Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $nonConformance->nc_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$nonConformance->status === 'closed' ? 'active' : ($nonConformance->status === 'open' ? 'inactive' : 'info')">
                            {{ ucwords(str_replace('_', ' ', $nonConformance->status)) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Severity</dt>
                    <dd>
                        <x-badge :status="$nonConformance->severity === 'critical' ? 'inactive' : ($nonConformance->severity === 'major' ? 'warning' : 'info')">
                            {{ ucfirst($nonConformance->severity) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Defect Type</dt>
                    <dd class="text-sm text-gray-700">{{ $nonConformance->defectType->name ?? $nonConformance->defect_type }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Quantity Affected</dt>
                    <dd class="text-sm text-gray-700">{{ number_format($nonConformance->quantity_affected, 0) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Responsible Department</dt>
                    <dd class="text-sm text-gray-700">{{ $nonConformance->responsible_department ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Description & Analysis" description="Issue details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Description</dt>
                    <dd class="text-sm text-gray-700">{{ $nonConformance->description }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Root Cause</dt>
                    <dd class="text-sm text-gray-700">{{ $nonConformance->root_cause ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Recommended Action</dt>
                    <dd class="text-sm text-gray-700">{{ $nonConformance->recommended_action ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Resolution Notes</dt>
                    <dd class="text-sm text-gray-700">{{ $nonConformance->resolution_notes ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Related Inspection" description="Source inspection">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Inspection #</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $nonConformance->inspection->inspection_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product</dt>
                    <dd class="text-sm text-gray-700">{{ $nonConformance->inspection->product->product_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Assigned To</dt>
                    <dd class="text-sm text-gray-700">{{ $nonConformance->assignedTo->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Resolved At</dt>
                    <dd class="text-sm text-gray-700">{{ $nonConformance->resolved_at ? $nonConformance->resolved_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    @if($nonConformance->correctiveActions->count() > 0)
        <x-card title="Corrective Actions" description="Actions linked to this non-conformance">
            <x-table :headers="['Action #', 'Type', 'Status', 'Actions']" :rows="$nonConformance->correctiveActions->map(fn($ca) => (object)[
                'cells' => [
                    $ca->action_number,
                    ucwords(str_replace('_', ' ', $ca->action_type)),
                    view('components.badge', ['status' => $ca->status === 'closed' ? 'active' : ($ca->status === 'open' ? 'inactive' : 'info')])->with('slot', ucwords(str_replace('_', ' ', $ca->status))),
                    '<a href="'.route('admin.quality-control.corrective-actions.show', $ca).'" class="text-blue-600 hover:text-blue-800">View</a>',
                ]
            ])" empty="No corrective actions.">
            </x-table>
        </x-card>
    @endif

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.quality-control.non-conformances.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('non-conformance-create')
                @if(in_array($nonConformance->status, ['open', 'in_progress']))
                    <form action="{{ route('admin.quality-control.non-conformances.resolve', $nonConformance) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="resolution_notes" value="Resolved">
                        <x-button variant="secondary" type="submit">Mark Resolved</x-button>
                    </form>
                @endif
                @if($nonConformance->status === 'resolved')
                    <form action="{{ route('admin.quality-control.non-conformances.close', $nonConformance) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Close</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

