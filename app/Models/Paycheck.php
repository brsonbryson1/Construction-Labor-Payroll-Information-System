<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paycheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pay_period_start',
        'pay_period_end',
        'pay_date',
        'gross_pay',
        'net_pay',
        'total_deductions',
        'regular_hours',
        'overtime_hours',
        'regular_pay',
        'overtime_pay',
        'status',
        'file_path',
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}