@php
$canAct = !in_array($event->status, ['posted', 'cancelled']);
@endphp
<div class="flex items-center space-x-2">
    @can('accounting-event-view')
        <a href="{{ route('admin.accounting.events.show', $event) }}" class="text-gray-600 hover:text-gray-800" title="View">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </a>
    @endcan
    @can('accounting-event-post')
        @if($canAct && $event->status !== 'failed')
            <form action="{{ route('admin.accounting.events.post', $event) }}" method="POST" class="inline" title="Post">
                @csrf
                <button type="submit" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($event->status === 'failed')
            <form action="{{ route('admin.accounting.events.repost', $event) }}" method="POST" class="inline" title="Repost">
                @csrf
                <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($canAct)
            <form action="{{ route('admin.accounting.events.cancel', $event) }}" method="POST" class="inline" title="Cancel">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </form>
        @endif
    @endcan
</div>
