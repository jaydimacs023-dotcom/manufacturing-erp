@extends('layouts.app')

@section('page-header', $qualityInspection->inspection_number)
@section('page-description', 'Quality Inspection details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Inspection Information" description="Basic inspection details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Inspection #</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $qualityInspection->inspection_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Type</dt>
                    <dd>
                        <x-badge status="info">{{ ucwords(str_replace('_', ' ', $qualityInspection->inspection_type)) }}</x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$qualityInspection->status === 'passed' ? 'active' : ($qualityInspection->status === 'failed' ? 'inactive' : ($qualityInspection->status === 'conditional' ? 'warning' : 'info'))">
                            {{ ucwords($qualityInspection->status) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Inspector</dt>
                    <dd class="text-sm text-gray-700">{{ $qualityInspection->inspector->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Inspection Date</dt>
                    <dd class="text-sm text-gray-700">{{ $qualityInspection->inspection_date ? $qualityInspection->inspection_date->format('Y-m-d H:i') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Completed At</dt>
                    <dd class="text-sm text-gray-700">{{ $qualityInspection->completed_at ? $qualityInspection->completed_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Product & Batch" description="Inspected item details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $qualityInspection->product->product_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Batch Number</dt>
                    <dd class="text-sm text-gray-700">{{ $qualityInspection->batch_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Lot Number</dt>
                    <dd class="text-sm text-gray-700">{{ $qualityInspection->lot_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Checklist</dt>
                    <dd class="text-sm text-gray-700">{{ $qualityInspection->checklist->name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Results Summary" description="Inspection results">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Items Inspected</dt>
                    <dd class="text-sm text-gray-700">{{ number_format($qualityInspection->quantity_inspected, 0) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Passed</dt>
                    <dd class="text-sm font-medium text-green-600">{{ number_format($qualityInspection->quantity_passed, 0) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Failed</dt>
                    <dd class="text-sm font-medium text-red-600">{{ number_format($qualityInspection->quantity_failed, 0) }}</dd>
                </div>
                @if($qualityInspection->approved_by)
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Approved By</dt>
                    <dd class="text-sm text-gray-700">{{ $qualityInspection->approver->name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Approved At</dt>
                    <dd class="text-sm text-gray-700">{{ $qualityInspection->approved_at ? $qualityInspection->approved_at->format('Y-m-d H:i') : '-' }}</dd>
                </div>
                @endif
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Remarks</dt>
                    <dd class="text-sm text-gray-700">{{ $qualityInspection->remarks ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <!-- Inspection Items / Results Recording -->
    @if($qualityInspection->items->count() > 0)
        <x-card title="Inspection Items" description="Test results">
            <form action="{{ route('admin.quality-control.inspections.record-results', $qualityInspection) }}" method="POST">
                @csrf
                @method('PUT')
                <x-table :headers="['#', 'Item', 'Specification', 'Expected', 'Min', 'Max', 'Actual Value', 'Result', 'Remarks']" :rows="$qualityInspection->items->map(fn($item) => (object)[
                    'cells' => [
                        $item->sort_order,
                        $item->item_name,
                        $item->specification ?? '-',
                        $item->expected_value ?? '-',
                        $item->min_value ?? '-',
                        $item->max_value ?? '-',
                        '<input type="number" step="0.0001" name="items['.$item->id.'][actual_value]" value="'.old('items.'.$item->id.'.actual_value', $item->actual_value).'" class="rounded border border-gray-300 px-2 py-1 text-sm w-24">',
                        '<select name="items['.$item->id.'][result]" class="rounded border border-gray-300 px-2 py-1 text-sm">
                            <option value="pass" '.($item->result === 'pass' ? 'selected' : '').'>Pass</option>
                            <option value="fail" '.($item->result === 'fail' ? 'selected' : '').'>Fail</option>
                            <option value="conditional" '.($item->result === 'conditional' ? 'selected' : '').'>Conditional</option>
                        </select>',
                        '<input type="text" name="items['.$item->id.'][remarks]" value="'.old('items.'.$item->id.'.remarks', $item->remarks).'" class="rounded border border-gray-300 px-2 py-1 text-sm w-32">',
                    ]
                ])" empty="No inspection items.">
                </x-table>
                @if(in_array($qualityInspection->status, ['draft']))
                <div class="mt-4 flex justify-end">
                    <x-button variant="primary" type="submit">Record Results</x-button>
                </div>
                @endif
            </form>
        </x-card>
    @endif

    <!-- Non-Conformances -->
    @if($qualityInspection->nonConformances->count() > 0)
        <x-card title="Non-Conformances" description="Recorded defects">
            <x-table :headers="['NC #', 'Defect Type', 'Severity', 'Qty Affected', 'Status', 'Actions']" :rows="$qualityInspection->nonConformances->map(fn($nc) => (object)[
                'cells' => [
                    $nc->nc_number,
                    $nc->defectType->name ?? $nc->defect_type,
                    view('components.badge', ['status' => $nc->severity === 'critical' ? 'inactive' : ($nc->severity === 'major' ? 'warning' : 'info')])->with('slot', ucfirst($nc->severity)),
                    number_format($nc->quantity_affected, 0),
                    view('components.badge', ['status' => $nc->status === 'closed' ? 'active' : ($nc->status === 'open' ? 'inactive' : 'info')])->with('slot', ucwords(str_replace('_', ' ', $nc->status))),
                    '<a href="'.route('admin.quality-control.non-conformances.show', $nc).'" class="text-blue-600 hover:text-blue-800 text-sm">View</a>',
                ]
            ])" empty="No non-conformances.">
            </x-table>
        </x-card>
    @endif

    <!-- Corrective Actions -->
    @if($qualityInspection->correctiveActions->count() > 0)
        <x-card title="Corrective Actions" description="Actions taken">
            <x-table :headers="['Action #', 'Type', 'Status', 'Due Date', 'Actions']" :rows="$qualityInspection->correctiveActions->map(fn($ca) => (object)[
                'cells' => [
                    $ca->action_number,
                    ucwords(str_replace('_', ' ', $ca->action_type)),
                    view('components.badge', ['status' => $ca->status === 'closed' ? 'active' : ($ca->status === 'open' ? 'inactive' : 'info')])->with('slot', ucwords(str_replace('_', ' ', $ca->status))),
                    $ca->due_date ? $ca->due_date->format('Y-m-d') : '-',
                    '<a href="'.route('admin.quality-control.corrective-actions.show', $ca).'" class="text-blue-600 hover:text-blue-800 text-sm">View</a>',
                ]
            ])" empty="No corrective actions.">
            </x-table>
        </x-card>
    @endif

    <div class="flex items-center justify-between space-x-3">
        <x-button variant="secondary" href="{{ route('admin.quality-control.inspections.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('inspection-create')
                @if($qualityInspection->status === 'draft')
                    <a href="{{ route('admin.quality-control.inspections.edit', $qualityInspection) }}">
                        <x-button variant="secondary" type="button">Edit</x-button>
                    </a>
                @endif
                @if(in_array($qualityInspection->status, ['draft']))
                    <form action="{{ route('admin.quality-control.inspections.conditional', $qualityInspection) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="secondary" type="submit">Accept Conditionally</x-button>
                    </form>
                @endif
            @endcan
            @can('inspection-approve')
                @if(in_array($qualityInspection->status, ['draft', 'conditional']))
                    <form action="{{ route('admin.quality-control.inspections.approve', $qualityInspection) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Approve / Pass</x-button>
                    </form>
                    <form action="{{ route('admin.quality-control.inspections.reject', $qualityInspection) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this inspection?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Reject / Fail</x-button>
                    </form>
                @endif
            @endcan
            @can('inspection-create')
                @if(!in_array($qualityInspection->status, ['cancelled']))
                    <form action="{{ route('admin.quality-control.inspections.cancel', $qualityInspection) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to cancel this inspection?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection

