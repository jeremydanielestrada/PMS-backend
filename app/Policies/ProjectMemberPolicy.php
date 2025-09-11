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

        return false;
    }




}
