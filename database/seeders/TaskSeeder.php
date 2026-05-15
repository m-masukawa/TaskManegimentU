<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
        public function run(): void
    {
        // 3人のユーザーを作り、それぞれに5個ずつタスクを紐づける
        \App\Models\User::factory(3)->create()->each(function ($user) {
            \App\Models\Task::factory(5)->create(['user_id' => $user->id]);
        });
    }
}
