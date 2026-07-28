@props(['headers' => [], 'rows' => [], 'empty' => 'No records found.', 'actionLabel' => null, 'actionRoute' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden']) }}>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            @if(count($headers) > 0)
                <thead class="bg-gray-50">
                    <tr>
                        @foreach($headers as $header)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $header }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="bg-white divide-y divide-gray-200">
                @if(count($rows) > 0)
                    @foreach($rows as $row)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            @foreach($row->cells ?? $row as $cell)
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    @if($cell instanceof \Illuminate\Contracts\Support\Renderable)
                                        {!! $cell->render() !!}
                                    @elseif(is_string($cell) && str_starts_with(ltrim($cell), '<'))
                                        {!! $cell !!}
                                    @else
                                        {{ $cell }}
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                @elseif(!$slot->isEmpty())
                    {{ $slot }}
                @else
                    <tr>
                        <td colspan="{{ count($headers) }}" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                <p class="text-gray-500 text-sm">{{ $empty }}</p>
                                @if($actionLabel && $actionRoute)
                                    <x-button variant="primary" size="sm" href="{{ $actionRoute }}" class="mt-3">
                                        {{ $actionLabel }}
                                    </x-button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
