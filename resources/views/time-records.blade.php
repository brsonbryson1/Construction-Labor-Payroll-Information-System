<x-app-layout>
    @section('page-title', 'Time Records')

    {{-- Page Header --}}
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Time Records</h2>
        <p class="text-gray-500 mt-1">Clock in and out, view your attendance history</p>
    </div>

    {{-- Livewire Component --}}
    @livewire('time-records')
</x-app-layout>
