<nav class="bg-white rounded-md shadow-none border px-4 py-2 w-full">
    <div class="flex items-center justify-between gap-3">
        <ol class="flex items-center text-sm text-gray-500 space-x-2">
            <!-- Home -->
            <li class="flex items-center">
                <a href="/" class="flex items-center text-primary hover:text-primary">
                    <svg class="w-4 h-4 mx-2 text-primary" fill="currentColor" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9a1.5 1.5 0 0 1-1.5-1.5z"/>
                        <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.646 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z"/>
                    </svg>
                    <span>Home</span>
                </a>
            </li>

            <!-- Dynamic breadcrumbs -->
            @for ($i = 0; $i < 10; $i++)
                @php
                    $slotVar = 'url_' . $i;
                    $slotValue = isset($$slotVar) ? json_decode($$slotVar, true) : null;
                @endphp

                @if (!empty($slotValue) && is_array($slotValue))
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7"/>
                        </svg>
                        <a href="{{ $slotValue['link'] ?? '#' }}" class="text-primary hover:text-primary">
                            {{ $slotValue['text'] ?? 'Plan Panther - ' . $i }}
                        </a>
                    </li>
                @endif
            @endfor

            <!-- Current Page -->
            @if (!empty($active))
                <li class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                    <span class="text-gray-500 mx-2">{{ $active }}</span>
                </li>
            @endif
        </ol>
    </div>
</nav>
