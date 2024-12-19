<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use App\Models\AttendanceSetting;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use \Illuminate\Database\Eloquent\Model;


class EditAttendance extends EditRecord
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Update login, logout times, and other relevant fields
        $record->login_time = $data['login_time'] ?? $record->login_time;
        $record->logout_time = $data['logout_time'] ?? $record->logout_time;
        $record->date = $data['date'] ?? $record->date; // Update date if provided
        // $record->status = $data['status'] ?? $record->status;

        // Recalculate metrics
        $loginTime = Carbon::create($record->login_time);
        $logoutTime = Carbon::create($record->logout_time);

        $totalWorkingMin = $loginTime->diffInMinutes($logoutTime);
        [$thours, $tminutes] = explode(':', AttendanceSetting::first()?->total_working_hours ?? 9);
        [$lunchHours, $lunchMinutes] = explode(':', AttendanceSetting::first()?->lunch_hours ?? 1);
        $minimumWorkingMinutes = (($thours * 60) + $tminutes);

        [$lhours, $lminutes] = explode(':', $loginTime->toTimeString());

        $total_working_hours = $totalWorkingMin < 0 ? 0 : max(($totalWorkingMin / 60) - ($lunchHours + $lunchMinutes), 0);
        $overtime_hours = $totalWorkingMin > $minimumWorkingMinutes
            ? ($totalWorkingMin - $minimumWorkingMinutes) / 60
            : 0;
        $late_login = (int)$lhours > 9 ? true : false;
        $early_checkout = $totalWorkingMin < $minimumWorkingMinutes ? true : false;

        // Save the updated record
        $record->save();

        $record->update([
            'total_working_hours' => $total_working_hours,
            'overtime_hours' => $overtime_hours,
            'late_login' => $late_login,
            'early_checkout' => $early_checkout,
        ]);

        // Update related attendance data
        $record->attendancelog()->create($record->toArray());

        return $record;
    }
}
