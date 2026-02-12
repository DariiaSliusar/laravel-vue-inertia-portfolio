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
                'category' => 'Backend',
            ],
            [
                'name' => 'Laravel Framework (Routing, Controllers, Middleware, Eloquent ORM & Migrations, Queues & Scheduler, Service Container & Service Providers)',
                'category' => 'Backend',
            ],

            // Frontend
            [
                'name' => 'JavaScript',
                'category' => 'Frontend',
            ],
            [
                'name' => 'Vue.js',
                'category' => 'Frontend',
            ],
            [
                'name' => 'HTML/CSS',
                'category' => 'Frontend',
            ],
            [
                'name' => 'Tailwind CSS',
                'category' => 'Frontend',
            ],
            [
                'name' => 'Bootstrap',
                'category' => 'Frontend',
            ],
            // Database
            [
                'name' => 'MySQL / PostgreSQL / SQLite',
                'category' => 'Database',
            ],
            [
                'name' => 'Redis (Caching, Queues)',
                'category' => 'Database',
            ],
            // Tools
            [
                'name' => 'Git',
                'category' => 'Tools',
            ],
            [
                'name' => 'Docker',
                'category' => 'Tools',
            ],
            [
                'name' => 'Linux',
                'category' => 'Tools',
            ],
        ]);
    }
}
