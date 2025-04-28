<?php

namespace App\Filament\Resources\PayslipStructureResource\Pages;

use App\Filament\Resources\PayslipStructureResource;
use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Deduction;
use App\Models\Employee;
use App\Models\GeneratedPaySlips;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;


class CreatePayslipStructure extends CreateRecord
{
    protected static string $resource = PayslipStructureResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $start_date = Carbon::parse($data["start_date"]);
        $end_date = Carbon::parse($data["end_date"]);

        $employees = Employee::all();
        $payslip =  static::getModel()::create($data);

        foreach ($employees as $employee) {

            $attendanceRecords = Attendance::where("employee_id", $employee->id)
                ->whereBetween('date', [$start_date, $end_date])
                ->with('employee') // Eager load related employee details if needed
                ->get();
            
            
            $total_working_hours = $attendanceRecords->sum('total_working_hours') + $attendanceRecords->sum('overtime_hours');
            $overtime_hours = $attendanceRecords->sum('overtime_hours');

            $base_salary = $employee->salary;
            $salary_per_day = $base_salary / 24; // 24 working days
            $salary_per_hour = $salary_per_day / 8; // 8 total working hours
            $working_amount = $salary_per_hour * $total_working_hours;
            $pf_contribution = ($working_amount / 100) * $employee->pf_contribution;

            $allowance = Allowance::whereHas('employees', fn($query) => $query->where('employee_id', $employee->id))->sum('allowance') ?? 0; // Default to 0 if not found
            $deduction = Deduction::whereHas('employees', fn($query) => $query->where('employee_id', $employee->id))->sum('deduction') ?? 0; // Default to 0 if not found

            $net_salary = ($salary_per_hour * $total_working_hours) + $allowance - $deduction - $pf_contribution;



           GeneratedPaySlips::create([
                    'payslip_name' => $data['payslip_name'],
                    'payslip_id' => $payslip->id,
                    'employee_name' => $employee->first_name,
                    'base_salary' => $base_salary,
                    'allowance' => $allowance,
                    'deduction' => $deduction,
                    'pf_contribution' => $pf_contribution,
                    'net_salary' => $net_salary,
                    'total_working_hours' => $total_working_hours,
                    'total_overtime_hours' => $overtime_hours,
                    'start_date'           => $data['start_date'],
                    'end_date'             => $data['end_date'],
                ]);
        }

  
        return $payslip;
  }

}
