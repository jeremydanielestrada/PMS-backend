<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{

    public function before(User $user){
        if($user->isAdmin()){
            return true;
        }

    }


   public function create(User $user){
        // Allow admins (handled by before method) or project leaders
        return $user->isAdmin() || $user->isProjectLeader();

    }

    public function update(User $user, Task $task){
        return $user->isAdmin() || $user->isProjectLeader() && $user->id == $task->assigned_to;
    }

    public function delete(User $user, Task $task){
        return $user->isAdmin() ||  $user->isProjectLeader() && $user->id == $task->assigned_to;
    }


}
