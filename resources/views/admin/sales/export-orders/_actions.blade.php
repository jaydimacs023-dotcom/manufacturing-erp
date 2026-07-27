@php
$canAct = !in_array($exportOrder->status, ['delivered', 'cancelled']);
@endphp
<div class="flex items-center space-x-2">
    @can('export-order-view')
        <a href="{{ route('admin.sales.export-orders.show', $exportOrder) }}" class="text-gray-600 hover:text-gray-800" title="View">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </a>
    @endcan
    @can('export-order-update')
        @if($exportOrder->status === 'draft')
            <a href="{{ route('admin.sales.export-orders.edit', $exportOrder) }}" class="text-indigo-600 hover:text-indigo-800" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
        @endif
    @endcan
    @can('export-order-approve')
        @if($exportOrder->status === 'draft')
            <form action="{{ route('admin.sales.export-orders.approve', $exportOrder) }}" method="POST" class="inline" title="Approve / Plan">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>
        @endif
    @endcan
    @can('export-order-update')
        @if($exportOrder->status === 'planned')
            <form action="{{ route('admin.sales.export-orders.load', $exportOrder) }}" method="POST" class="inline" title="Mark Loaded">
                @csrf
                <button type="submit" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($exportOrder->status === 'loaded')
            <form action="{{ route('admin.sales.export-orders.dispatch', $exportOrder) }}" method="POST" class="inline" title="Dispatch">
                @csrf
                <button type="submit" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($exportOrder->status === 'dispatched')
            <form action="{{ route('admin.sales.export-orders.in-transit', $exportOrder) }}" method="POST" class="inline" title="In Transit">
                @csrf
                <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($exportOrder->status === 'in_transit')
            <form action="{{ route('admin.sales.export-orders.delivered', $exportOrder) }}" method="POST" class="inline" title="Mark Delivered">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($canAct)
            <form action="{{ route('admin.sales.export-orders.cancel', $exportOrder) }}" method="POST" class="inline" title="Cancel">
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

