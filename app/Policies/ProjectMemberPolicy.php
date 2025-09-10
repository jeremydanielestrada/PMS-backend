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

        return null;
    }


    public function create(User $user): bool
    {
        return  $user->role === 'leader';
    }


    public function update(User $user, ProjectMember $projectMember): bool
    {
          return  $user->role === 'leader' &&  $user->id ===  $projectMember->user_id;
    }


    public function delete(User $user, ProjectMember $projectMember): bool
    {
        return  $user->role === 'leader' &&  $user->id ===  $projectMember->user_id;
    }


}
