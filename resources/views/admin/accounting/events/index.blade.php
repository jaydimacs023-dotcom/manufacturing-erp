@extends('layouts.app')

@section('page-header', 'Accounting Events')
@section('page-description', 'View and manage accounting events')

@section('content')
<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-stat-card title="Total Events" value="{{ $events->total() }}" />
        <x-stat-card title="Pending" value="{{ $pendingCount }}" />
        <x-stat-card title="Today Postings" value="{{ $todayPostings->count() }}" />
    </div>

    <div class="flex items-center justify-between">
        <div>
            <select class="rounded-lg border border-gray-300 px-3 py-2 text-sm" onchange="window.location.href=this.value">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="posted" {{ request('status') === 'posted' ? 'selected' : '' }}>Posted</option>
                <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
    </div>

    <x-table :headers="['Event #', 'Transaction Type', 'Transaction #', 'Module', 'Amount', 'Status', 'Actions']" :rows="$events->map(fn($e) => (object)[
        'cells' => [
            $e->event_number,
            ucwords(str_replace('_', ' ', $e->transaction_type)),
            $e->transaction_number,
            ucfirst($e->source_module),
            number_format($e->total_amount, 2),
            view('components.badge', ['status' => $e->status === 'posted' ? 'active' : ($e->status === 'failed' ? 'inactive' : ($e->status === 'pending' ? 'in-progress' : 'info'))])->with('slot', ucfirst($e->status)),
            view('admin.accounting.events._actions', ['event' => $e])->render(),
        ]
    ])" empty="No accounting events found.">
    </x-table>

    <div class="mt-4">
        {{ $events->links() }}
    </div>
</div>
@endsection
