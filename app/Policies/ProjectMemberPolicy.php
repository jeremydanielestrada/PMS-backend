<?php

namespace App\Policies;

use App\Models\ProjectMember;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectMemberPolicy
{

      // Admins can bypass all policy checks
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }

    }




    public function create(User $user){
        return $user->isLeader();
    }



    public function update(User $user){
        return $user->isLeader();
    }



    public function delete(User $user){
        return $user->isLeader();
    }

}
