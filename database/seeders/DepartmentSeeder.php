<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Human Resources', 'description' => 'Handles employee relations and staffing.'],
            ['name' => 'IT Department', 'description' => 'Manages IT infrastructure and software.'],
            ['name' => 'Finance', 'description' => 'Oversees budgeting and accounting.'],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
