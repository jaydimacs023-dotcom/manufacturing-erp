@extends('layouts.app')

@section('page-header', $queue->queue_number)
@section('page-description', 'Posting queue details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <x-card title="Queue Information" description="Posting queue details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Queue Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $queue->queue_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$queue->status === 'posted' ? 'active' : ($queue->status === 'failed' ? 'inactive' : 'info')">
                            {{ ucfirst($queue->status) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Retry Count</dt>
                    <dd class="text-sm text-gray-700">{{ $queue->retry_count }} / {{ $queue->max_retries }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Processing Details" description="Timeline">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Created At</dt>
                    <dd class="text-sm text-gray-700">{{ $queue->created_at->format('Y-m-d H:i:s') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Processed At</dt>
                    <dd class="text-sm text-gray-700">{{ $queue->processed_at ? $queue->processed_at->format('Y-m-d H:i:s') : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Processed By</dt>
                    <dd class="text-sm text-gray-700">{{ $queue->processor->name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    @if($queue->error_message)
    <x-card title="Error Information">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-sm text-red-700">{{ $queue->error_message }}</p>
        </div>
    </x-card>
    @endif

    <div class="flex items-center justify-between">
        <x-button variant="secondary" href="{{ route('admin.accounting.posting-queue.index') }}">Back to Queue</x-button>
        <div class="flex items-center space-x-2">
            @can('accounting-event-post')
                @if($queue->status === 'pending')
                    <form action="{{ route('admin.accounting.posting-queue.process', $queue) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Process Now</x-button>
                    </form>
                @endif
                @if($queue->status === 'failed')
                    <form action="{{ route('admin.accounting.posting-queue.retry', $queue) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Retry</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
