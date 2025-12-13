@props(['submit'])

<div {{ $attributes->merge(['class' => '']) }}>
    {{-- Section Header --}}
    <div class="mb-4 px-1">
        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <form wire:submit="{{ $submit }}">
            <div class="p-4 sm:p-6">
                <div class="space-y-4">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 border-t border-gray-100 sm:px-6">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
