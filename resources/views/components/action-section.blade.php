<div {{ $attributes->merge(['class' => '']) }}>
    {{-- Section Header --}}
    <div class="mb-4 px-1">
        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
    </div>

    {{-- Content Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-4 sm:p-6">
            {{ $content }}
        </div>
    </div>
</div>
