@php
$canStart = $ca->status === 'open';
$canComplete = $ca->status === 'in_progress';
$canApprove = $ca->status === 'completed';
@endphp
<div class="flex items-center space-x-2">
    @can('corrective-action-view')
        <a href="{{ route('admin.quality-control.corrective-actions.show', $ca) }}" class="text-gray-600 hover:text-gray-800" title="View">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
        </a>
    @endcan
    @can('corrective-action-create')
        @if($canStart)
            <form action="{{ route('admin.quality-control.corrective-actions.start', $ca) }}" method="POST" class="inline" title="Start">
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
            <form action="{{ route('admin.quality-control.corrective-actions.complete', $ca) }}" method="POST" class="inline" title="Complete">
                @csrf
                <input type="hidden" name="action_taken" value="Completed">
                <input type="hidden" name="is_effective" value="1">
                <button type="submit" class="text-yellow-600 hover:text-yellow-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </button>
            </form>
        @endif
    @endcan
    @can('inspection-approve')
        @if($canApprove)
            <form action="{{ route('admin.quality-control.corrective-actions.approve', $ca) }}" method="POST" class="inline" title="Approve & Close">
                @csrf
                <button type="submit" class="text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </button>
            </form>
        @endif
    @endcan
</div>

