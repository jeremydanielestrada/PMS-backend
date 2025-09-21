<?php

namespace App\Policies;

use App\Models\ProjectMember;
use App\Models\User;

class ProjectMemberPolicy
{

      // Admins can bypass all policy checks
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true;
        }

    }




     public function create(User $user)
    {
        // Allow admins (handled by before) or project leaders
        return $user->isProjectLeader();
    }




    public function delete(User $user, ProjectMember $member)
    {
        // Allow admins or project owner or project leaders
        $project = $member->project;
        return $user->id === $project->owner_id || $user->isProjectLeader();
    }
}

