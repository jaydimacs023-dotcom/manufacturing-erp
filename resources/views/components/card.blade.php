@props(['title' => '', 'description' => '', 'footer' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden']) }}>
    @if($title || $description)
        <div class="px-6 py-4 border-b border-gray-200">
            @if($title)
                <h3 class="text-base font-semibold text-gray-900">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="px-6 py-4">
        {{ $slot }}
    </div>

    @if($footer)
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-200">
            {{ $footer }}
        </div>
    @endif
</div>

