<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::insert([
            [
                'title' => 'Creating web applications from scratch',
                'icon' => 'fa-solid fa-building-circle-check',
                'description' => 'Developing full-featured, scalable, and secure applications using Laravel as a backend framework.',
            ],
            [
                'title' => 'Support and refinement of existing projects',
                'icon' => 'fa-solid fa-wand-magic-sparkles',
                'description' => 'Creating user-friendly mobile applications.',
            ],
            [
                'title' => 'Additional and Support Services',
                'icon' => 'fa-solid fa-plus',
                'description' => 'Fixing bugs in existing code;
                                  Creating and configuring databases (Migrations);
                                  Configuring queues (Queues);
                                  Working with Blade templates, creating forms with backend validation (using Laravel Validation).',
            ],
        ]);
    }
}
