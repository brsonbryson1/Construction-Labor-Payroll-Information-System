<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    
    <h1 class="text-3xl font-bold text-gray-900 mb-8 flex items-center">
        <svg class="w-8 h-8 inline me-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Employee Time Tracker
    </h1>

    {{-- Alert for Success/Error Messages --}}
    @if ($message)
        <div class="p-4 mb-4 text-sm rounded-lg {{ $currentRecord ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}" role="alert">
            <span class="font-medium">{{ $message }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- CARD 1: CLOCK IN/OUT ACTION --}}
        <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg border border-gray-100 text-center">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Your Current Status</h3>
            
            {{-- Status Display --}}
            <div class="mb-6">
                @if ($currentRecord)
                    <p class="text-4xl font-extrabold text-green-600">
                        CLOCK OUT
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Clocked In at: {{ Carbon\Carbon::parse($currentRecord->clock_in)->format('h:i A') }}
                    </p>
                @else
                    <p class="text-4xl font-extrabold text-indigo-600">
                        CLOCK IN
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Ready to start your shift.
                    </p>
                @endif
            </div>

            {{-- Clock Action Button (Dynamically toggles between Clock In and Clock Out) --}}
            @if ($currentRecord)
                {{-- Clock Out Button (Red) --}}
                <button 
                    wire:click="clockOut" 
                    class="w-full py-4 rounded-lg text-white font-bold text-lg transition duration-150 shadow-md 
                           bg-red-600 hover:bg-red-700"
                >
                    CLOCK OUT NOW
                </button>
            @else
                {{-- Clock In Button (Indigo) --}}
                <button 
                    wire:click="clockIn" 
                    class="w-full py-4 rounded-lg text-white font-bold text-lg transition duration-150 shadow-md 
                           bg-indigo-600 hover:bg-indigo-700"
                >
                    CLOCK IN NOW
                </button>
            @endif
            
            <p class="text-xs text-gray-500 mt-4">Time is automatically recorded upon clicking.</p>
        </div>

        {{-- CARD 2: TODAY'S ACTIVITY LOG --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg border border-gray-100">
            <h3 class="text-xl font-semibold mb-4 text-gray-700">Today's Activity Log</h3>
            
            <div class="space-y-4">
                @php
                    $todayRecord = $history->firstWhere(fn($record) => Carbon\Carbon::parse($record->clock_in)->isToday());
                @endphp
                
                @if ($todayRecord)
                    {{-- Clock In --}}
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <p class="font-medium text-gray-800">Clock In</p>
                            <p class="text-sm text-green-600">Time Recorded</p>
                        </div>
                        <p class="text-lg font-semibold">{{ Carbon\Carbon::parse($todayRecord->clock_in)->format('h:i A') }}</p>
                    </div>

                    {{-- Clock Out --}}
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <p class="font-medium text-gray-800">Clock Out</p>
                            <p class="text-sm text-gray-500">{{ $todayRecord->clock_out ? 'Time Recorded' : 'Pending...' }}</p>
                        </div>
                        <p class="text-lg font-semibold">
                            {{ $todayRecord->clock_out ? Carbon\Carbon::parse($todayRecord->clock_out)->format('h:i A') : '--:--' }}
                        </p>
                    </div>

                    {{-- FIXED: Total Hours Today with Livewire Polling for active shifts --}}
                    <div class="pt-4 border-t-2 border-dashed mt-4">
                        <p class="text-base font-semibold text-gray-800">Total Hours Today: 
                            <span class="text-indigo-600">
                                @if ($currentRecord)
                                    {{-- Use wire:poll to update elapsed time every 5 seconds for an active shift --}}
                                    <span wire:poll.5000ms>{{ $timeElapsed ?? '0.00 hours' }}</span>
                                @else
                                    {{ $todayRecord->hours_worked ?? '0.00 hours' }}
                                @endif
                            </span>
                        </p>
                    </div>
                @else
                    <p class="text-gray-500 italic">No activity recorded for today.</p>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Time Log History Table --}}
    <div class="mt-8 bg-white p-6 rounded-xl shadow-lg border border-gray-100">
        <h3 class="text-xl font-semibold mb-4 text-gray-700">Last 10 Time Logs</h3>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clock In</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Clock Out</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Hours</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($history as $record)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ Carbon\Carbon::parse($record->clock_in)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ Carbon\Carbon::parse($record->clock_in)->format('h:i A') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $record->clock_out ? Carbon\Carbon::parse($record->clock_out)->format('h:i A') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $record->hours_worked ?? '--' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if (!$record->clock_out)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Active</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Complete</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500 italic">No time records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>