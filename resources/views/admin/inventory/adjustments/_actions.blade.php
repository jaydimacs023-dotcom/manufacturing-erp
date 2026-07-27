@php $canEdit = $adjustment->status === 'draft'; @endphp
<div class="flex items-center space-x-2">
    @can('inventory-view')
        <a href="{{ route('admin.inventory.adjustments.show', $adjustment) }}" class="text-gray-600 hover:text-gray-800" title="View">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </a>
    @endcan
    @can('inventory-adjust')
        @if($adjustment->status === 'draft')
            <a href="{{ route('admin.inventory.adjustments.edit', $adjustment) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </a>
            <form action="{{ route('admin.inventory.adjustments.submit', $adjustment) }}" method="POST" class="inline" title="Submit for Approval">
                @csrf
                <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </form>
        @endif
        @if($adjustment->status === 'pending_approval')
            <form action="{{ route('admin.inventory.adjustments.approve', $adjustment) }}" method="POST" class="inline" title="Approve">
                @csrf
                <button type="submit" class="text-green-600 hover:text-green-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>
            <button type="button" onclick="document.getElementById('reject-form-{{ $adjustment->id }}').classList.toggle('hidden')" class="text-red-600 hover:text-red-800" title="Reject">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <form id="reject-form-{{ $adjustment->id }}" action="{{ route('admin.inventory.adjustments.reject', $adjustment) }}" method="POST" class="inline hidden" onsubmit="return prompt('Enter rejection reason:') ? (document.getElementById('reject-reason-{{ $adjustment->id }}').value = prompt('Enter rejection reason:')) : false">
                @csrf
                <input type="hidden" name="rejection_reason" id="reject-reason-{{ $adjustment->id }}">
            </form>
        @endif
        @if(!in_array($adjustment->status, ['approved', 'rejected', 'cancelled']))
            <form action="{{ route('admin.inventory.adjustments.cancel', $adjustment) }}" method="POST" class="inline" title="Cancel" onsubmit="return confirm('Are you sure you want to cancel this adjustment?')">
                @csrf
                <button type="submit" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </form>
        @endif
        @if(in_array($adjustment->status, ['draft', 'cancelled']))
            <form action="{{ route('admin.inventory.adjustments.destroy', $adjustment) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this adjustment?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800" title="Delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </form>
        @endif
    @endcan
</div>

