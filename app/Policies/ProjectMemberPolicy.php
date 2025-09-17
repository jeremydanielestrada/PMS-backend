<?php

namespace App\Policies;

use App\Models\ProjectMember;
use App\Models\User;
use App\Models\Project;
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




    public function create(User $user,  Project $project){
       return $user->isLeader() || $project->id === $project->owner_id;
    }



    public function update(User $user, Project $project){
        return $user->isLeader() || $project->id === $project->owner_id;
    }



    public function delete(User $user,  Project $project){
         return $user->isLeader() || $project->id === $project->owner_id;
    }

}
