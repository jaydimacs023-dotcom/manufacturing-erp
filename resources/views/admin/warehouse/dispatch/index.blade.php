@extends('layouts.app')

@section('page-header', 'Dispatch')
@section('page-description', 'Manage shipment dispatch operations')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div>
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="">All Status</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="packed" {{ request('status') === 'packed' ? 'selected' : '' }}>Packed</option>
                <option value="loaded" {{ request('status') === 'loaded' ? 'selected' : '' }}>Loaded</option>
                <option value="dispatched" {{ request('status') === 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        @can('dispatch-create')
            <x-button variant="primary" href="{{ route('admin.warehouse.dispatch.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Dispatch
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Dispatch #', 'Type', 'Product', 'Qty', 'Destination', 'Status', 'Actions']" :rows="$dispatches->map(fn($d) => (object)[
        'cells' => [
            $d->dispatch_number,
            ucfirst($d->dispatch_type),
            $d->product->product_name ?? '-',
            number_format($d->quantity, 0),
            $d->destination ?? '-',
            view('components.badge', ['status' => $d->status === 'dispatched' ? 'active' : ($d->status === 'cancelled' ? 'inactive' : ($d->status === 'loaded' ? 'in-progress' : 'info'))])->with('slot', ucfirst($d->status)),
            view('admin.warehouse.dispatch._actions', ['dispatch' => $d])->render(),
        ]
    ])" empty="No dispatch records found.">
    </x-table>

    <div class="mt-4">
        {{ $dispatches->links() }}
    </div>
</div>
@endsection

