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
        ]);

        Setting::set('hourly_rate', $request->hourly_rate);
        Setting::set('deduction_percentage', $request->deduction_percentage);

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'settings' => [
                'hourly_rate' => $request->hourly_rate,
                'deduction_percentage' => $request->deduction_percentage,
            ]
        ]);
    }

    public function getSettings()
    {
        return response()->json([
            'hourly_rate' => Setting::getHourlyRate(),
            'deduction_percentage' => Setting::getDeductionPercentage(),
        ]);
    }
}
