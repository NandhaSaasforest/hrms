<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'date',
        'login_time',
        'logout_time',
        'status',
        'late_login',
        'early_checkout',
        'total_working_hours',
        'overtime_hours',
        'attendance_log_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function attendancelog()
    {
        return $this->hasMany(AttendanceLog::class, 'attendance_id');
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }

}
