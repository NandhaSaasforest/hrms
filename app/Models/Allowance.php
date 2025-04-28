<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    protected $fillable = [
        'name',
        "allowance",
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'allowance_employee')->withTimestamps();
    }
}
