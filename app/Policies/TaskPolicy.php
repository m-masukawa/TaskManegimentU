<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // 一蘭
    }

    public function view(User $user, Task $task): bool
    {
        // 閲覧OK
        return $user->id === $task->user_id;
    }

    public function create(User $user): bool
    {
        return true; // アクセスOK
    }

    public function update(User $user, Task $task): bool
    {
        //更新
        return $user->id === $task->user_id;
    }

    public function delete(User $user, Task $task): bool
    {
        //削除
        return $user->id === $task->user_id;
    }
}