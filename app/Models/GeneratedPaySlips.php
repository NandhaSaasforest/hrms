<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneratedPaySlips extends Model
{

    protected $fillable = [
        "employee_name",
        "payslip_name",
        'payslip_id',
        'total_working_hours',
        'total_overtime_hours',
        'base_salary',
        'allowance',
        'deduction',
        'pf_contribution',
        'net_salary',
        'start_date',
        'end_date',
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function payslip()
    {
        return $this->belongsTo(PayslipStructure::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
