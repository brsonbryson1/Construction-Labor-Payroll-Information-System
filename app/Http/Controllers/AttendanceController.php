<?php

namespace App\Http\Controllers;

use App\Models\TimeRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $selectedDate = Carbon::parse($date);

        // Get all employees
        $employees = User::where('role', 'Employee')->get();

        // Get time records for the selected date
        $timeRecords = TimeRecord::whereDate('clock_in', $selectedDate)
            ->with('user')
            ->get()
            ->keyBy('user_id');

        // Build attendance data
        $attendance = $employees->map(function ($employee) use ($timeRecords) {
            $record = $timeRecords->get($employee->id);
            return [
                'user' => $employee,
                'record' => $record,
                'status' => $record ? ($record->clock_out ? 'Complete' : 'In Progress') : 'Absent',
            ];
        });

        // Stats
        $stats = [
            'total' => $employees->count(),
            'present' => $timeRecords->count(),
            'absent' => $employees->count() - $timeRecords->count(),
            'totalHours' => $timeRecords->sum('hours_worked') ?? 0,
        ];

        return view('attendance.index', compact('attendance', 'selectedDate', 'stats'));
    }
}
