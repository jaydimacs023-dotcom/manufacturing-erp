@php
$canEdit = in_array($order->status, ['draft', 'planned']);
$canStart = $order->status === 'released';
$canComplete = $order->status === 'in_progress';
$canClose = $order->status === 'quality_inspection';
$canCancel = !in_array($order->status, ['completed', 'cancelled']);
@endphp
<div class="flex items-center space-x-2">
    @can('manufacturing-order-view')
        <a href="{{ route('admin.manufacturing.orders.show', $order) }}" class="text-gray-600 hover:text-gray-800" title="View">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </a>
    @endcan
    @can('manufacturing-order-update')
        @if($canEdit)
            <a href="{{ route('admin.manufacturing.orders.edit', $order) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
        @endif
        @if($canStart)
            <form action="{{ route('admin.manufacturing.orders.start', $order) }}" method="POST" class="inline" title="Start Production">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($canComplete)
            <form action="{{ route('admin.manufacturing.orders.complete', $order) }}" method="POST" class="inline" title="Complete Production">
                @csrf
                <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($canClose)
            <form action="{{ route('admin.manufacturing.orders.close', $order) }}" method="POST" class="inline" title="Close Order">
                @csrf
                <button type="submit" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($canCancel)
            <form action="{{ route('admin.manufacturing.orders.cancel', $order) }}" method="POST" class="inline" title="Cancel" onsubmit="return confirm('Are you sure you want to cancel this order?')">
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
