@extends('layouts.app')

@section('page-header', 'Bill of Materials')
@section('page-description', 'Manage production BOMs')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search BOMs..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        <div class="flex items-center space-x-2">
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="{{ route('admin.manufacturing.bom.index') }}">All Status</option>
                <option value="{{ route('admin.manufacturing.bom.index', ['status' => 'draft']) }}" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="{{ route('admin.manufacturing.bom.index', ['status' => 'approved']) }}" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="{{ route('admin.manufacturing.bom.index', ['status' => 'active']) }}" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="{{ route('admin.manufacturing.bom.index', ['status' => 'inactive']) }}" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @can('bom-create')
                <x-button variant="primary" href="{{ route('admin.manufacturing.bom.create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    New BOM
                </x-button>
            @endcan
        </div>
    </div>

    <x-table :headers="['BOM #', 'Product', 'Version', 'Effective Date', 'Status', 'Actions']" :rows="$boms->map(fn($bom) => (object)[
        'cells' => [
            $bom->bom_number,
            $bom->product->product_name ?? '-',
            $bom->version,
            $bom->effective_date ? $bom->effective_date->format('Y-m-d') : '-',
            view('components.badge', ['status' => $bom->status === 'approved' || $bom->status === 'active' ? 'active' : ($bom->status === 'inactive' ? 'inactive' : 'info')])->with('slot', ucfirst($bom->status)),
            view('admin.manufacturing.bom._actions', ['bom' => $bom])->render(),
        ]
    ])" empty="No Bill of Materials found." actionLabel="New BOM" actionRoute="{{ route('admin.manufacturing.bom.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $boms->links() }}
    </div>
</div>
@endsection
