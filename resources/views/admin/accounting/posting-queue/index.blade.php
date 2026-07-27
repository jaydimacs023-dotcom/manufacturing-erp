@extends('layouts.app')

@section('page-header', 'Posting Queue')
@section('page-description', 'Manage accounting posting queue')

@section('content')
<div class="space-y-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-stat-card title="Total Queue" value="{{ $queueItems->total() }}" />
        <x-stat-card title="Pending" value="{{ $pendingItems->count() }}" />
        <x-stat-card title="Failed" value="{{ $failedItems->count() }}" />
    </div>

    <div class="flex items-center justify-between">
        <div></div>
        <div class="flex items-center space-x-2">
            @can('accounting-event-post')
                @if($pendingItems->count() > 0)
                    <form action="{{ route('admin.accounting.posting-queue.process-all') }}" method="POST">
                        @csrf
                        <x-button variant="primary" type="submit">Process All Pending</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>

    <x-table :headers="['Queue #', 'Event #', 'Status', 'Retry', 'Error', 'Actions']" :rows="$queueItems->map(fn($q) => (object)[
        'cells' => [
            $q->queue_number,
            $q->accountingEvent->event_number ?? '-',
            view('components.badge', ['status' => $q->status === 'posted' ? 'active' : ($q->status === 'failed' ? 'inactive' : 'info')])->with('slot', ucfirst($q->status)),
            "{$q->retry_count}/{$q->max_retries}",
            $q->error_message ? \Illuminate\Support\Str::limit($q->error_message, 50) : '-',
            view('admin.accounting.posting-queue._actions', ['queue' => $q])->render(),
        ]
    ])" empty="No posting queue items found.">
    </x-table>

    <div class="mt-4">
        {{ $queueItems->links() }}
    </div>
</div>
@endsection
