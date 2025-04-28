<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        "total_working_hours",
        "lunch_hours",
        "grace_time_minutes",
    ];
}
