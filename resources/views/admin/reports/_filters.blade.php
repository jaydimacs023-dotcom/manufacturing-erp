@props(['route' => '', 'showStatus' => true, 'showProduct' => false])

<form action="{{ $route }}" method="GET" class="flex flex-wrap items-end gap-4">
    <div>
        <label class="block text-xs font-medium text-gray-700 mb-1">Date From</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}"
               class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-700 mb-1">Date To</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}"
               class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
    </div>
    @if($showStatus)
    <div>
        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
        <select name="status" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <option value="">All</option>
            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
    </div>
    @endif
    <div>
        <x-button variant="primary" type="submit">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
            </svg>
            Filter
        </x-button>
        <a href="{{ $route }}" class="text-sm text-gray-500 hover:text-gray-700 ml-2">Clear</a>
    </div>
</form>

