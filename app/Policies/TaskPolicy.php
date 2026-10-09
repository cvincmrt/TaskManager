<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        //zamknutie ulohy ked je splnena
        if($task->status === 'completed')
        {
            return false;
        }

        return $user->id === $task->creator_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        if($task->status === 'completed')
        {
            return false;
        }

        return $user->id === $task->creator_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Task $task): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        return false;
    }

    public function changeStatus(User $user, Task $task)
    {
        if($task->status === 'completed')
        {
            return false;
        }

        return $user->id === $task->creator_id || $user->id === $task->assigned_to_id;

    }

    public function assign(User $user, Task $task)
    {
        return $task->assigned_to_id === null && $task->status !== 'completed';
    }
}
