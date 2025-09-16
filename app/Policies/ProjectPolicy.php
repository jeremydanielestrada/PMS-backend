<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProjectPolicy
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
        return $user->isAdmin();
    }




}
