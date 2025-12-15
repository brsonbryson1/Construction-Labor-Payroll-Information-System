<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'description'];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            return self::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value)
    {
        $setting = self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget("setting_{$key}");

        return $setting;
    }

    /**
     * Get hourly rate
     */
    public static function getHourlyRate()
    {
        return (float) self::get('hourly_rate', 100);
    }

    /**
     * Get deduction percentage
     */
    public static function getDeductionPercentage()
    {
        return (float) self::get('deduction_percentage', 10);
    }

    /**
     * Get regular hours per day
     */
    public static function getRegularHoursPerDay()
    {
        return (float) self::get('regular_hours_per_day', 8);
    }

    /**
     * Get overtime multiplier
     */
    public static function getOvertimeMultiplier()
    {
        return (float) self::get('overtime_multiplier', 1.25);
    }

    /**
     * Check if time clock is enabled
     */
    public static function isTimeClockEnabled()
    {
        return self::get('time_clock_enabled', '1') === '1';
    }
}
