<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
            'user_id' => \App\Models\User::factory(), // ユーザーも自動生成
            'title' => fake()->realText(20),
            'description' => fake()->realText(100),
            'status' => fake()->randomElement(['todo', 'doing', 'done']),
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
