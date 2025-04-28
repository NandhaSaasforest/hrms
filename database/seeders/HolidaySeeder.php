<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Holiday::insert([
            ['holiday_date' => '2024-01-01', 'description' => 'New Year\'s Day', 'created_at' => now(), 'updated_at' => now()],
            ['holiday_date' => '2024-12-25', 'description' => 'Christmas Day', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
