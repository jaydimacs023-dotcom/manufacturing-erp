@extends('layouts.app')

@section('page-header', 'Quality Inspections')
@section('page-description', 'Manage incoming, in-process, and final inspections')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search inspections..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.quality-control.inspections.index') }}">All Status</option>
                <option value="{{ route('admin.quality-control.inspections.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.quality-control.inspections.index', ['status' => 'passed']) }}" {{ request('status') === 'passed' ? 'selected' : '' }}>Passed</option>
                <option value="{{ route('admin.quality-control.inspections.index', ['status' => 'conditional']) }}" {{ request('status') === 'conditional' ? 'selected' : '' }}>Conditional</option>
                <option value="{{ route('admin.quality-control.inspections.index', ['status' => 'failed']) }}" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="{{ route('admin.quality-control.inspections.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.quality-control.inspections.index') }}">All Types</option>
                <option value="{{ route('admin.quality-control.inspections.index', ['type' => 'incoming']) }}" {{ request('type') === 'incoming' ? 'selected' : '' }}>Incoming QC</option>
                <option value="{{ route('admin.quality-control.inspections.index', ['type' => 'in_process']) }}" {{ request('type') === 'in_process' ? 'selected' : '' }}>In-Process QC</option>
                <option value="{{ route('admin.quality-control.inspections.index', ['type' => 'final']) }}" {{ request('type') === 'final' ? 'selected' : '' }}>Final QC</option>
            </select>
            @can('inspection-create')
                <x-button variant="primary" href="{{ route('admin.quality-control.inspections.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Inspection
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['Inspection #', 'Type', 'Product', 'Inspector', 'Date', 'Status', 'Actions']" :rows="$inspections->map(fn($inspection) => (object)[
        'cells' => [
            $inspection->inspection_number,
            view('components.badge', ['status' => 'info'])->with('slot', ucwords(str_replace('_', ' ', $inspection->inspection_type))),
            $inspection->product->product_name ?? '-',
            $inspection->inspector->name ?? '-',
            $inspection->inspection_date ? $inspection->inspection_date->format('Y-m-d') : '-',
            view('components.badge', ['status' => $inspection->status === 'passed' ? 'active' : ($inspection->status === 'failed' ? 'inactive' : ($inspection->status === 'conditional' ? 'warning' : 'info'))])->with('slot', ucwords($inspection->status)),
            view('admin.quality-control.inspection._actions', ['inspection' => $inspection])->render(),
        ]
    ])" empty="No inspections found." actionLabel="New Inspection" actionRoute="{{ route('admin.quality-control.inspections.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $inspections->links() }}
    </div>
</div>
@endsection

