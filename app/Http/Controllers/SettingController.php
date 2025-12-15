<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hourly_rate' => 'required|numeric|min:1',
            'deduction_percentage' => 'required|numeric|min:0|max:100',
            'regular_hours_per_day' => 'nullable|numeric|min:1|max:24',
            'overtime_multiplier' => 'nullable|numeric|min:1|max:5',
            'time_clock_enabled' => 'nullable|in:0,1',
        ]);

        Setting::set('hourly_rate', $request->hourly_rate);
        Setting::set('deduction_percentage', $request->deduction_percentage);
        
        if ($request->has('regular_hours_per_day')) {
            Setting::set('regular_hours_per_day', $request->regular_hours_per_day);
        }
        if ($request->has('overtime_multiplier')) {
            Setting::set('overtime_multiplier', $request->overtime_multiplier);
        }
        if ($request->has('time_clock_enabled')) {
            Setting::set('time_clock_enabled', $request->time_clock_enabled);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'settings' => [
                'hourly_rate' => $request->hourly_rate,
                'deduction_percentage' => $request->deduction_percentage,
                'regular_hours_per_day' => Setting::getRegularHoursPerDay(),
                'overtime_multiplier' => Setting::getOvertimeMultiplier(),
                'time_clock_enabled' => Setting::isTimeClockEnabled(),
            ]
        ]);
    }

    public function getSettings()
    {
        return response()->json([
            'hourly_rate' => Setting::getHourlyRate(),
            'deduction_percentage' => Setting::getDeductionPercentage(),
            'regular_hours_per_day' => Setting::getRegularHoursPerDay(),
            'overtime_multiplier' => Setting::getOvertimeMultiplier(),
            'time_clock_enabled' => Setting::isTimeClockEnabled(),
        ]);
    }
}
