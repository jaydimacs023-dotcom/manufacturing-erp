@extends('layouts.app')

@section('page-header', $correctiveAction->action_number)
@section('page-description', 'Corrective action details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Action Information" description="Basic details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Action #</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $correctiveAction->action_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$correctiveAction->status === 'closed' ? 'active' : ($correctiveAction->status === 'open' ? 'inactive' : 'info')">
                            {{ ucwords(str_replace('_', ' ', $correctiveAction->status)) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Action Type</dt>
                    <dd class="text-sm text-gray-700">{{ ucwords(str_replace('_', ' ', $correctiveAction->action_type)) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Responsible Person</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->responsiblePerson->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Due Date</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->due_date ? $correctiveAction->due_date->format('Y-m-d') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Completed At</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->completed_at ? $correctiveAction->completed_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Description & Result" description="Details and outcome">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Description</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->description }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Action Taken</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->action_taken ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Result Notes</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->result_notes ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Is Effective</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->is_effective ? 'Yes' : ($correctiveAction->is_effectie === null ? '-' : 'No') }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Related Records" description="Linked quality records">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Inspection #</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $correctiveAction->inspection->inspection_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->inspection->product->product_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Non-Conformance</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->nonConformance->nc_number ?? '-' }}</dd>
                </div>
                @if($correctiveAction->approved_by)
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Approved By</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->approver->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Approved At</dt>
                    <dd class="text-sm text-gray-700">{{ $correctiveAction->approved_at ? $correctiveAction->approved_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
                @endif
            </dl>
        </x-card>
    </div>

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.quality-control.corrective-actions.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('corrective-action-create')
                @if($correctiveAction->status === 'open')
                    <form action="{{ route('admin.quality-control.corrective-actions.start', $correctiveAction) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Start Action</x-button>
                    </form>
                @endif
                @if($correctiveAction->status === 'in_progress')
                    <form action="{{ route('admin.quality-control.corrective-actions.complete', $correctiveAction) }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="action_taken" value="Action completed as planned.">
                        <input type="hidden" name="is_effective" value="1">
                        <x-button variant="primary" type="submit">Mark Complete</x-button>
                    </form>
                @endif
            @endcan
            @can('inspection-approve')
                @if($correctiveAction->status === 'completed')
                    <form action="{{ route('admin.quality-control.corrective-actions.approve', $correctiveAction) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Approve & Close</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

