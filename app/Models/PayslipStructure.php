<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayslipStructure extends Model
{
    protected $fillable = [
        'payslip_name',
        'start_date',
        'end_date',
        // 'base_salary',
        // 'allowance',
        // 'deduction',
        // 'pf_contribution',
        // 'net_salary',
    ];

    public function generatePayslip()
    {
        return $this->hasMany(GeneratedPaySlips::class, 'payslip_id');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::saving(function ($payslip) {
    //         $payslip->net_salary = $payslip->base_salary + $payslip->allowance - $payslip->deduction - $payslip->pf_contribution;
    //     });
    // }

}
