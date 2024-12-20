<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::all();
        $startDate = Carbon::create(2024, 12, 1);
        $endDate = Carbon::create(2024, 12, 31);

        foreach ($employees as $employee) {
            $date = $startDate->copy();

            while ($date->lte($endDate)) {
                // Generate random data
                $loginTime = Carbon::parse($startDate->format('Y-m-d') . ' ' . rand(8, 10) . ':' . rand(0, 59));
                $logoutTime = (clone $loginTime)->addHours(rand(6, 10))->addMinutes(rand(0, 59));
                $totalWorkingHours = $loginTime->diffInHours($logoutTime);
                $overtimeHours = max(0, $totalWorkingHours - 8); // Assuming 9 hours is standard working time

                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date->toDateString(),
                    'login_time' => $loginTime->toTimeString(),
                    'logout_time' => $logoutTime->toTimeString(),
                    'late_login' => $loginTime->hour > 9, // Late if login is after 9 AM
                    'early_checkout' => $totalWorkingHours < 9, // Early checkout if less than 9 hours
                    'total_working_hours' => $totalWorkingHours,
                    'overtime_hours' => $overtimeHours,
                ]);
                $date->addDay();
            }
        }
    }
}
