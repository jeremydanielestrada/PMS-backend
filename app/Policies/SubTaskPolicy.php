<?php

namespace App\Policies;

use App\Models\SubTask;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SubTaskPolicy
{


    public function before(User $user){

        if ($user->isAdmin()){

            return true;
        }

         return null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SubTask $subTask): bool
    {
        return $subTask->task->project->members->pluck('user_id')->contains($user->id);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Subtask $subTask): bool
    {
        return $subTask->task->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SubTask $subTask): bool
    {
       return $subTask->task->assigned_to === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SubTask $subTask): bool
    {
        return $subTask->task->assigned_to === $user->id;
    }

}
