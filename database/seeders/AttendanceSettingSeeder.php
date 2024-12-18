<?php

namespace Database\Seeders;

use App\Models\AttendanceSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timings = [
            "total_working_hours"=> "09:00:00",
            "lunch_hours"=> "01:00:00",
            "grace_time_minutes"=> "15",
        ];

        
        AttendanceSetting::create($timings);
    }
}
