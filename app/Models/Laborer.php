<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laborer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'job_position',
        'daily_rate',
        'contact',
    ];
    
}
