<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Status::factory(5)->create();
        \App\Models\Project::factory(15)->create();
        \App\Models\Task::factory(50)->create();
    }
}
