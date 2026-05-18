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
        // 所有者、または管理者なら閲覧OK
        return $user->id === $task->user_id || $user->is_admin;
    }

    public function create(User $user): bool
    {
        return true; // アクセスOK
    }

        public function update(User $user, Task $task): bool
    {
        // 所有者、または管理者なら編集・更新OK
        return $user->id === $task->user_id || $user->is_admin;
    }

        public function delete(User $user, Task $task): bool
    {
        // 所有者、または管理者なら削除OK
        return $user->id === $task->user_id || $user->is_admin;
    }
}