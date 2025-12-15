<div>
    {{-- Time Clock Disabled Notice --}}
    @if(!$timeClockEnabled)
        <div style="background: #fef3c7; border: 1px solid #f59e0b; border-radius: 12px; padding: 16px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <i class="bi bi-exclamation-triangle" style="color: #d97706; font-size: 24px;"></i>
                <div>
                    <p style="margin: 0; font-size: 14px; font-weight: 600; color: #92400e;">Time Clock Disabled</p>
                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #a16207;">The time clock is currently disabled by the administrator. Please contact your manager.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Clock In/Out Card --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 20px; margin-bottom: 20px; {{ !$timeClockEnabled ? 'opacity: 0.6;' : '' }}">
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div>
                <h3 style="margin: 0; font-size: 18px; font-weight: 600; color: #1f2937;">Current Status</h3>
                <p style="margin: 6px 0 0 0; font-size: 14px; color: #6b7280;">{{ $timeClockEnabled ? $status : 'Time clock is disabled' }}</p>
            </div>
            
            <div>
                @if(!$currentRecord || $currentRecord->clock_out)
                    <button wire:click="clockIn" 
                            {{ !$timeClockEnabled ? 'disabled' : '' }}
                            style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px 24px; background: {{ $timeClockEnabled ? '#A99066' : '#d1d5db' }}; color: white; font-weight: 600; font-size: 16px; border: none; border-radius: 12px; cursor: {{ $timeClockEnabled ? 'pointer' : 'not-allowed' }};">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Clock In
                    </button>
                @else
                    <button wire:click="clockOut" 
                            {{ !$timeClockEnabled ? 'disabled' : '' }}
                            style="display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 14px 24px; background: {{ $timeClockEnabled ? '#dc2626' : '#d1d5db' }}; color: white; font-weight: 600; font-size: 16px; border: none; border-radius: 12px; cursor: {{ $timeClockEnabled ? 'pointer' : 'not-allowed' }};">
                        <i class="bi bi-box-arrow-right"></i>
                        Clock Out
                    </button>
                @endif
            </div>
        </div>

        @if($message)
            <div style="margin-top: 16px; padding: 12px 16px; background: rgba(169,144,102,0.1); border: 1px solid rgba(169,144,102,0.3); border-radius: 10px; color: #8B7355; font-size: 14px;">
                <i class="bi bi-info-circle" style="margin-right: 8px;"></i>{{ $message }}
            </div>
        @endif
    </div>

    {{-- Time Records History --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">Recent Time Records</h3>
        </div>
        
        {{-- Mobile Card View --}}
        <div class="mobile-records" style="display: block;">
            @forelse($history as $record)
                <div style="padding: 16px; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div>
                            <p style="margin: 0; font-size: 14px; font-weight: 600; color: #1f2937;">{{ $record->clock_in->format('M d, Y') }}</p>
                            <p style="margin: 4px 0 0 0; font-size: 12px; color: #6b7280;">{{ $record->clock_in->format('l') }}</p>
                        </div>
                        @if($record->hours_worked)
                            <span style="background: #A99066; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;">
                                {{ number_format($record->hours_worked, 1) }} hrs
                            </span>
                        @else
                            <span style="background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                In Progress
                            </span>
                        @endif
                    </div>
                    <div style="display: flex; gap: 24px;">
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Clock In</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 500; color: #16a34a;">{{ $record->clock_in->format('h:i A') }}</p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Clock Out</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 500; color: {{ $record->clock_out ? '#ef4444' : '#9ca3af' }};">
                                {{ $record->clock_out ? $record->clock_out->format('h:i A') : '—' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 48px 16px; text-align: center; color: #6b7280;">
                    <i class="bi bi-clock-history" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 12px;"></i>
                    <p style="margin: 0; font-size: 14px;">No time records found.</p>
                    <p style="margin: 4px 0 0 0; font-size: 13px; color: #9ca3af;">Clock in to start tracking!</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="desktop-records" style="display: none; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Date</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Clock In</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Clock Out</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Hours Worked</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($history as $record)
                        <tr style="border-top: 1px solid #e5e7eb;">
                            <td style="padding: 16px; font-size: 14px; font-weight: 500; color: #1f2937;">
                                {{ $record->clock_in->format('M d, Y') }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #16a34a; font-weight: 500;">
                                {{ $record->clock_in->format('h:i A') }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: {{ $record->clock_out ? '#ef4444' : '#9ca3af' }}; font-weight: 500;">
                                {{ $record->clock_out ? $record->clock_out->format('h:i A') : '—' }}
                            </td>
                            <td style="padding: 16px;">
                                @if($record->hours_worked)
                                    <span style="background: #A99066; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                        {{ number_format($record->hours_worked, 1) }} hrs
                                    </span>
                                @else
                                    <span style="background: #fef3c7; color: #b45309; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                        In Progress
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 48px; text-align: center; color: #6b7280;">
                                <i class="bi bi-clock-history" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 12px;"></i>
                                No time records found. Clock in to start tracking!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <style>
        @media (min-width: 768px) {
            .mobile-records { display: none !important; }
            .desktop-records { display: block !important; }
        }
    </style>
</div>
