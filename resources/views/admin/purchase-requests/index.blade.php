@extends('layouts.app')

@section('page-header', 'Purchase Requests')
@section('page-description', 'Manage purchase requests from departments')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search purchase requests..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.purchase-requests.index') }}">All Status</option>
                <option value="{{ route('admin.purchase-requests.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.purchase-requests.index', ['status' => 'submitted']) }}" {{ request('status') === 'submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="{{ route('admin.purchase-requests.index', ['status' => 'approved']) }}" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="{{ route('admin.purchase-requests.index', ['status' => 'rejected']) }}" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="{{ route('admin.purchase-requests.index', ['status' => 'converted_to_po']) }}" {{ request('status') === 'converted_to_po' ? 'selected' : '' }}>Converted to PO</option>
                <option value="{{ route('admin.purchase-requests.index', ['status' => 'cancelled']) }}" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            @can('purchase-request-create')
                <x-button variant="primary" href="{{ route('admin.purchase-requests.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New Purchase Request
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['Request #', 'Date', 'Department', 'Priority', 'Status', 'Actions']" :rows="$purchaseRequests->map(fn($pr) => (object)[
        'cells' => [
            $pr->request_number,
            $pr->request_date->format('Y-m-d'),
            $pr->department->department_name ?? '-',
            view('components.badge', ['status' => $pr->priority === 'urgent' ? 'danger' : ($pr->priority === 'high' ? 'warning' : 'info')])->with('slot', ucfirst($pr->priority)),
            view('components.badge', ['status' => $pr->status === 'approved' ? 'active' : ($pr->status === 'draft' ? 'info' : ($pr->status === 'rejected' || $pr->status === 'cancelled' ? 'inactive' : 'warning'))])->with('slot', ucwords(str_replace('_', ' ', $pr->status))),
            view('admin.purchase-requests._actions', ['purchaseRequest' => $pr])->render(),
        ]
    ])" empty="No purchase requests found." actionLabel="New Purchase Request" actionRoute="{{ route('admin.purchase-requests.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $purchaseRequests->links() }}
    </div>
</div>
@endsection
