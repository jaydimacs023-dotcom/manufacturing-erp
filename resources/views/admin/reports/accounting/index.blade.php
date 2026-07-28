@extends('layouts.app')

@section('page-header', 'Accounting Reports')
@section('page-description', 'Accounting events and posting status')

@section('content')
<div class="space-y-6">
    @include('admin.reports._filters', ['route' => route('admin.reports.accounting')])

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-stat-card label="Total Events" :value="$total_events" icon="file-text" color="blue" />
        <x-stat-card label="Pending" :value="$pending_events" icon="clock" color="yellow" />
        <x-stat-card label="Posted" :value="$posted_events" icon="check-circle" color="green" />
        <x-stat-card label="Failed" :value="$failed_events" icon="x-circle" color="red" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-stat-card label="Queue Pending" :value="$queue_pending" icon="clock" color="yellow" />
        <x-stat-card label="Queue Failed" :value="$queue_failed" icon="alert-triangle" color="red" />
    </div>

    <x-card title="Recent Accounting Events" description="Latest events">
        <x-table :headers="['Event #', 'Type', 'Status', 'Amount', 'Date']" :rows="collect($recent_events ?? [])->map(fn($e) => (object)[
            'cells' => [
                $e->event_number ?? '-',
                ucwords(str_replace('_', ' ', $e->transaction_type ?? '')),
                view('components.badge', ['status' => ($e->status ?? 'pending') === 'posted' ? 'active' : (($e->status ?? '') === 'failed' ? 'inactive' : 'info')])->with('slot', ucfirst($e->status ?? 'Pending'))->render(),
                number_format($e->total_amount ?? 0, 2),
                $e->created_at ? $e->created_at->format('Y-m-d') : '-',
            ]
        ])" empty="No accounting events found." />
    </x-card>

    <div class="flex items-center justify-end">
        <x-button variant="secondary" href="{{ route('admin.reports.index') }}">Back to Reports</x-button>
    </div>
</div>
@endsection
