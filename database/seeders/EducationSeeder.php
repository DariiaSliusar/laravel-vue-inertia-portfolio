<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Education::insert([
            [
                'institution' => 'Oles Honchar Dnipro National University',
                'period' => '2013 - 2017',
                'degree' => 'Bachelor of Science',
                'department' => 'Food technology',
            ],
            [
                'institution' => 'Oles Honchar Dnipro National University',
                'period' => '2017 - 2018',
                'degree' => 'Master of Science',
                'department' => 'Chemistry',
            ],
        ]);
    }
}
