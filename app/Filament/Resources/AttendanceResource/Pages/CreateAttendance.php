<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use App\Models\AttendanceLog;
use App\Models\AttendanceSetting;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use phpDocumentor\Reflection\Types\Null_;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;

    public function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {

        $loginTime = Carbon::create($data['login_time']);
        $logoutTime = Carbon::create($data["logout_time"]);

        $totalWorkingMin = $loginTime->diffInMinutes($logoutTime);

        [$thours, $tminutes] = explode(':', AttendanceSetting::first()?->total_working_hours ?? 9);
        [$lunchHours, $lunchMinutes] = explode(':', AttendanceSetting::first()?->lunch_hours ?? 1);
        $minimumWorkingMinutes = (($thours * 60) + $tminutes);
        // dd($minimumWorkingMinutes);

        [$lhours, $lminutes] = explode(':', $loginTime->toTimeString());

        $total_working_hours = $totalWorkingMin < 0 ? 0 : max(($totalWorkingMin / 60) - ($lunchHours + $lunchMinutes), 0);
        $overtime_hours = $totalWorkingMin > $minimumWorkingMinutes
            ? ($totalWorkingMin - $minimumWorkingMinutes) / 60
            : 0;
        $late_login = (int)$lhours + ((int)$lminutes / 60) > 9.25 ? true : false;
        $early_checkout = $totalWorkingMin < 0 ? false : ($totalWorkingMin < $minimumWorkingMinutes ? true : false);



        $attendance = static::getModel()::create([
            'employee_id' => $data['employee_id'],
            'login_time' => $data['login_time'],
            'logout_time' => $data['logout_time'],
            'total_working_hours' => $total_working_hours,
            'overtime_hours' => $overtime_hours,
            'date' => $data['date'],
            // 'status' => $data['status'],
            'late_login' => $late_login,
            'early_checkout' => $early_checkout,
        ]);

        $attendance->attendancelog()->create([
            'employee_id' => $attendance->employee_id,
            'login_time' => $attendance->login_time,
            'logout_time' => $attendance->logout_time,
            'date' => $attendance->date,
            // 'status' => $data['status'],
        ]);


        return $attendance;
    }
}
