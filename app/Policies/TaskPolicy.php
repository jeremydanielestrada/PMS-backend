<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{

    public function before(User $user){

        if ($user->isAdmin() || $user->isTeamLeader()) {

            return true;
        }

        return false;
    }



}
