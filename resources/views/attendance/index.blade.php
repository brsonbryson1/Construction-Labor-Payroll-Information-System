<x-app-layout>
    @section('page-title', 'Attendance')

    {{-- Page Header with Date Picker --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <div>
            <h2 style="margin: 0; font-size: 20px; font-weight: 700; color: #1f2937;">Daily Attendance</h2>
            <p style="margin: 4px 0 0 0; font-size: 14px; color: #6b7280;">Track employee attendance for {{ $selectedDate->format('F d, Y') }}</p>
        </div>
        <form method="GET" action="{{ route('attendance.index') }}" style="display: flex; gap: 8px; align-items: center;">
            <input type="date" name="date" value="{{ $selectedDate->format('Y-m-d') }}" 
                   style="padding: 10px 16px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px;">
            <button type="submit" style="background: #A99066; color: white; padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-weight: 500;">
                View
            </button>
        </form>
    </div>

    {{-- Stats Cards --}}
    <div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 20px;">
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Employees</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #1f2937;">{{ $stats['total'] }}</p>
                </div>
                <div style="width: 40px; height: 40px; background: rgba(169,144,102,0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-people" style="color: #A99066; font-size: 18px;"></i>
                </div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Present</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #16a34a;">{{ $stats['present'] }}</p>
                </div>
                <div style="width: 40px; height: 40px; background: #dcfce7; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-check-circle" style="color: #16a34a; font-size: 18px;"></i>
                </div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Absent</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #ef4444;">{{ $stats['absent'] }}</p>
                </div>
                <div style="width: 40px; height: 40px; background: #fee2e2; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-x-circle" style="color: #ef4444; font-size: 18px;"></i>
                </div>
            </div>
        </div>
        <div style="background: white; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <p style="margin: 0; font-size: 12px; color: #6b7280;">Total Hours</p>
                    <p style="margin: 4px 0 0 0; font-size: 24px; font-weight: 700; color: #1f2937;">{{ number_format($stats['totalHours'], 1) }}</p>
                </div>
                <div style="width: 40px; height: 40px; background: #f3e8ff; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <i class="bi bi-clock" style="color: #9333ea; font-size: 18px;"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Attendance List --}}
    <div style="background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
        <div style="padding: 16px; border-bottom: 1px solid #e5e7eb;">
            <h3 style="margin: 0; font-size: 16px; font-weight: 600; color: #1f2937;">Attendance Records</h3>
        </div>

        {{-- Mobile Card View --}}
        <div class="mobile-records" style="display: block;">
            @forelse($attendance as $item)
                <div style="padding: 16px; border-bottom: 1px solid #f3f4f6;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 12px;">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 40px; height: 40px; background: rgba(169,144,102,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person" style="color: #A99066; font-size: 18px;"></i>
                            </div>
                            <div>
                                <p style="margin: 0; font-size: 14px; font-weight: 600; color: #1f2937;">{{ $item['user']->name }}</p>
                                <p style="margin: 2px 0 0 0; font-size: 12px; color: #6b7280;">{{ $item['user']->email }}</p>
                            </div>
                        </div>
                        @if($item['status'] === 'Complete')
                            <span style="background: #dcfce7; color: #16a34a; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 500;">Complete</span>
                        @elseif($item['status'] === 'In Progress')
                            <span style="background: #fef3c7; color: #d97706; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 500;">In Progress</span>
                        @else
                            <span style="background: #fee2e2; color: #ef4444; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 500;">Absent</span>
                        @endif
                    </div>
                    <div style="display: flex; gap: 24px;">
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Clock In</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 500; color: #16a34a;">
                                {{ $item['record'] ? $item['record']->clock_in->format('h:i A') : '—' }}
                            </p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Clock Out</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 500; color: {{ $item['record'] && $item['record']->clock_out ? '#ef4444' : '#9ca3af' }};">
                                {{ $item['record'] && $item['record']->clock_out ? $item['record']->clock_out->format('h:i A') : '—' }}
                            </p>
                        </div>
                        <div>
                            <p style="margin: 0; font-size: 11px; color: #9ca3af; text-transform: uppercase;">Hours</p>
                            <p style="margin: 2px 0 0 0; font-size: 14px; font-weight: 600; color: #1f2937;">
                                {{ $item['record'] && $item['record']->hours_worked ? number_format($item['record']->hours_worked, 1) . ' hrs' : '—' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 48px 16px; text-align: center; color: #6b7280;">
                    <i class="bi bi-calendar-x" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 12px;"></i>
                    <p style="margin: 0; font-size: 14px;">No employees found.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table View --}}
        <div class="desktop-records" style="display: none; overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Employee</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Clock In</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Clock Out</th>
                        <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Hours</th>
                        <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendance as $item)
                        <tr style="border-top: 1px solid #e5e7eb;">
                            <td style="padding: 16px;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 36px; height: 36px; background: rgba(169,144,102,0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-person" style="color: #A99066;"></i>
                                    </div>
                                    <div>
                                        <p style="margin: 0; font-size: 14px; font-weight: 500; color: #1f2937;">{{ $item['user']->name }}</p>
                                        <p style="margin: 0; font-size: 12px; color: #6b7280;">{{ $item['user']->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #1f2937;">
                                {{ $item['record'] ? $item['record']->clock_in->format('h:i A') : '—' }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; color: #1f2937;">
                                {{ $item['record'] && $item['record']->clock_out ? $item['record']->clock_out->format('h:i A') : '—' }}
                            </td>
                            <td style="padding: 16px; font-size: 14px; font-weight: 600; color: #1f2937;">
                                {{ $item['record'] && $item['record']->hours_worked ? number_format($item['record']->hours_worked, 1) . ' hrs' : '—' }}
                            </td>
                            <td style="padding: 16px; text-align: center;">
                                @if($item['status'] === 'Complete')
                                    <span style="background: #dcfce7; color: #16a34a; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">Complete</span>
                                @elseif($item['status'] === 'In Progress')
                                    <span style="background: #fef3c7; color: #d97706; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">In Progress</span>
                                @else
                                    <span style="background: #fee2e2; color: #ef4444; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 500;">Absent</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="padding: 48px; text-align: center; color: #6b7280;">
                                <i class="bi bi-calendar-x" style="font-size: 48px; color: #d1d5db; display: block; margin-bottom: 12px;"></i>
                                No employees found.
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
        @media (max-width: 767px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr) !important; }
        }
        @media (max-width: 480px) {
            .stats-grid { grid-template-columns: 1fr !important; }
        }
    </style>
</x-app-layout>
