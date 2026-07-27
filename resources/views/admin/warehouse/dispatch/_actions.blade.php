@php
$canAct = !in_array($dispatch->status, ['dispatched', 'cancelled']);
@endphp
<div class="flex items-center space-x-2">
    @can('dispatch-view')
        <a href="{{ route('admin.warehouse.dispatch.show', $dispatch) }}" class="text-gray-600 hover:text-gray-800" title="View">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </a>
    @endcan
    @can('dispatch-create')
        @if($dispatch->status === 'draft' || $dispatch->status === 'packed')
            <form action="{{ route('admin.warehouse.dispatch.load', $dispatch) }}" method="POST" class="inline" title="Load">
                @csrf
                <button type="submit" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($dispatch->status === 'loaded')
            <form action="{{ route('admin.warehouse.dispatch.confirm', $dispatch) }}" method="POST" class="inline" title="Confirm">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($canAct)
            <form action="{{ route('admin.warehouse.dispatch.cancel', $dispatch) }}" method="POST" class="inline" title="Cancel">
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

