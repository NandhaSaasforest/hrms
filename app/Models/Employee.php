<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function Laravel\Prompts\alert;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'department_id',
        'is_manager',
        'shift_id',
        'salary',
        'employment_date',
        'address',
    ];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($employee) {
            if ($employee->is_manager) {
                // Generate password using the last 4 digits of the phone number
                $phone = $employee->phone; // Assuming the phone column exists
                $password = substr($phone, -4);

                // Check if the user already exists to avoid duplication
                if (!User::where('email', $employee->email)->exists()) {
                    // Create the user
                    User::create([
                        'name' => $employee->first_name,
                        'email' => $employee->email,
                        'password' => bcrypt($password), // Encrypt the password
                    ]);
                }
            }
        });
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
