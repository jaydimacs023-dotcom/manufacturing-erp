@extends('layouts.app')

@section('page-header', $event->event_number)
@section('page-description', 'Accounting event details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Event Information" description="Basic details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Event Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $event->event_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$event->status === 'posted' ? 'active' : ($event->status === 'failed' ? 'inactive' : ($event->status === 'pending' ? 'in-progress' : 'info'))">
                            {{ ucfirst($event->status) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Transaction Type</dt>
                    <dd class="text-sm text-gray-700">{{ ucwords(str_replace('_', ' ', $event->transaction_type)) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Transaction Number</dt>
                    <dd class="text-sm text-gray-700">{{ $event->transaction_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Source Module</dt>
                    <dd class="text-sm text-gray-700">{{ ucfirst($event->source_module) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Branch</dt>
                    <dd class="text-sm text-gray-700">{{ $event->branch->branch_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Financial Details" description="Amount and currency">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Total Amount</dt>
                    <dd class="text-lg font-bold text-gray-900">{{ number_format($event->total_amount, 2) }} {{ $event->currency }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Posting Date</dt>
                    <dd class="text-sm text-gray-700">{{ $event->posting_date->format('Y-m-d') }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Posted At</dt>
                    <dd class="text-sm text-gray-700">{{ $event->posted_at ? $event->posted_at->format('Y-m-d H:i:s') : '-' }}</dd>
                </div>
            </dl>
        </x-card>

        @if($mapping)
        <x-card title="Journal Mapping" description="Debit/Credit accounts">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Debit</dt>
                    <dd class="text-sm text-gray-700">
                        @if($mapping->debit_account_code)
                            {{ $mapping->debit_account_code }} - {{ $mapping->debit_account_name ?? '' }}
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Credit</dt>
                    <dd class="text-sm text-gray-700">
                        @if($mapping->credit_account_code)
                            {{ $mapping->credit_account_code }} - {{ $mapping->credit_account_name ?? '' }}
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Description</dt>
                    <dd class="text-sm text-gray-700">{{ $mapping->description ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
        @endif
    </div>

    @if($event->error_message)
    <x-card title="Error Information" description="Posting failure details">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-sm text-red-700">{{ $event->error_message }}</p>
            <p class="text-xs text-red-500 mt-2">Retry count: {{ $event->retry_count }}</p>
        </div>
    </x-card>
    @endif

    <div class="flex items-center justify-between">
        <x-button variant="secondary" href="{{ route('admin.accounting.events.index') }}">Back to List</x-button>
        <div class="flex items-center space-x-2">
            @can('accounting-event-post')
                @if(!in_array($event->status, ['posted', 'cancelled']))
                    <form action="{{ route('admin.accounting.events.post', $event) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Post Event</x-button>
                    </form>
                @endif
                @if($event->status === 'failed')
                    <form action="{{ route('admin.accounting.events.repost', $event) }}" method="POST" class="inline">
                        @csrf
                        <x-button variant="primary" type="submit">Repost Event</x-button>
                    </form>
                @endif
                @if(!in_array($event->status, ['posted', 'cancelled']))
                    <form action="{{ route('admin.accounting.events.cancel', $event) }}" method="POST" class="inline" onsubmit="return confirm('Cancel this accounting event?')">
                        @csrf
                        <x-button variant="secondary" type="submit">Cancel</x-button>
                    </form>
                @endif
            @endcan
        </div>
    </div>
</div>
@endsection
