<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deduction extends Model
{
    protected $fillable = ['employee_id','name', 'deduction',];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'deduction_employee')->withTimestamps();
    }
}
