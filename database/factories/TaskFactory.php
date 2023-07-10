<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'project_id' => Project::all()->random(1)->pluck('id')[0],
            'status_id' => Status::all()->random(1)->pluck('id')[0],
            'user_id' => User::all()->random(1)->pluck('id')[0]
        ];
    }
}
