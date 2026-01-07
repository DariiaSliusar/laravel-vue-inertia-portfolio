<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Skill::insert([
            // Backend
            [
                'name' => 'PHP',
                'proficiency' => 85,
                'category' => 'Backend',
            ],
            [
                'name' => 'Laravel Framework (Routing, Controllers, Middleware, Eloquent ORM & Migrations, Queues & Scheduler, IoC Container & Service Providers)',
                'proficiency' => 90,
                'category' => 'Backend',
            ],

            // Frontend
            [
                'name' => 'JavaScript',
                'proficiency' => 80,
                'category' => 'Frontend',
            ],
            [
                'name' => 'Vue.js',
                'proficiency' => 80,
                'category' => 'Frontend',
            ],
            [
                'name' => 'HTML/CSS',
                'proficiency' => 95,
                'category' => 'Frontend',
            ],
            [
                'name' => 'Tailwind CSS',
                'proficiency' => 90,
                'category' => 'Frontend',
            ],
            [
                'name' => 'Bootstrap',
                'proficiency' => 90,
                'category' => 'Frontend',
            ],
            // Database
            [
                'name' => 'MySQL / PostgreSQL / SQLite',
                'proficiency' => 90,
                'category' => 'Database',
            ],
            [
                'name' => 'Redis (Caching, Queues)',
                'proficiency' => 75,
                'category' => 'Database',
            ],
            // Tools
            [
                'name' => 'Git',
                'proficiency' => 90,
                'category' => 'Tools',
            ],
            [
                'name' => 'Docker',
                'proficiency' => 90,
                'category' => 'Tools',
            ],
            [
                'name' => 'Linux',
                'proficiency' => 95,
                'category' => 'Tools',
            ],
        ]);
    }
}
