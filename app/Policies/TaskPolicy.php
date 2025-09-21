<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;

class TaskPolicy
{
    public function before(User $user)
    {
        if ($user->isAdmin()) {
            return true; // Admins can do everything
        }
    }

    public function create(User $user, Project $project = null)
    {
        if (!$project) return false;

        // Team members can create tasks in projects they belong to
        return $user->projectMembers()
            ->where('project_id', $project->id)
            ->whereIn('role', ['leader', 'member'])
            ->exists();
    }

    public function update(User $user, Task $task)
    {
        // Can update if: assigned user OR project leader
        return $task->assigned_to === $user->id ||
               $this->isProjectLeader($user, $task->project_id);
    }

    public function delete(User $user, Task $task)
    {
        // Can delete if: project leader (since no created_by field)
        return $this->isProjectLeader($user, $task->project_id);
    }

    private function isProjectLeader(User $user, $projectId)
    {
        return $user->projectMembers()
            ->where('project_id', $projectId)
            ->where('role', 'leader')
            ->exists();
    }
}
