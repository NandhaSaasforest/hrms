<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = [
            [
                'first_name' => 'John',
                'last_name' => ' Deuv',
                'email' => 'asd@gmail.com',
                'phone' => '1234123',
                'department_id' => '1',
                'shift_id' => '2',
                'salary' => '12342',
                'employment_date' => '2024-12-03',
                'address' => 'asdfghj'
            ],
            [
                'first_name' => 'Michael',
                'last_name' => ' Deuv',
                'email' => 'asdsdf@gmail.com',
                'phone' => '1234233',
                'department_id' => '1',
                'shift_id' => '2',
                'salary' => '12342',
                'employment_date' => '2024-12-03',
                'address' => 'asdfghsdfj'
            ],
            [
                'first_name' => 'Naive',
                'last_name' => ' King',
                'email' => 'as@gmail.com',
                'phone' => '45674233',
                'department_id' => '3',
                'shift_id' => '1',
                'salary' => '12342',
                'employment_date' => '2024-12-06',
                'address' => 'asdfghqwdsfgsdfj'
            ],
            [
                'first_name' => 'Barou',
                'last_name' => ' Nike',
                'email' => 'asdswertdf@gmail.com',
                'phone' => '9874233',
                'department_id' => '1',
                'shift_id' => '3',
                'salary' => '52342',
                'employment_date' => '2024-12-08',
                'address' => 'asdfsdfghjkghsdfj'
            ],
            [
                'first_name' => 'Rin',
                'last_name' => ' Shel',
                'email' => 'asdlkj@gmail.com',
                'phone' => '1234287',
                'department_id' => '3',
                'shift_id' => '2',
                'salary' => '12342',
                'employment_date' => '2024-12-02',
                'address' => 'asdfghsdkjhgffj'
            ]
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
}
