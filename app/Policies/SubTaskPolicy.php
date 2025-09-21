<?php

namespace App\Policies;

use App\Models\SubTask;
use App\Models\User;
use \App\Models\Task;

class SubTaskPolicy
{


    public function before(User $user){

        if ($user->isAdmin()){

            return true;
        }

    }

    public function view(User $user, SubTask $subTask): bool
    {
        return $subTask->task->project->members->pluck('user_id')->contains($user->id);
    }


   public function create(User $user, $taskId = null)
    {
        if (!$taskId) return false;

        $task =Task::find($taskId);
        if (!$task) return false;

        // Can create if: task is assigned to user OR user is project leader
        return $task->assigned_to === $user->id ||
               $this->isProjectLeader($user, $task->project_id);
    }

       public function update(User $user, SubTask $subtask)
    {
        $task = $subtask->task;

        // Can update if: task owner OR project leader
        return $task->assigned_to === $user->id ||
               $this->isProjectLeader($user, $task->project_id);
    }


    public function delete(User $user, SubTask $subtask)
    {
        $task = $subtask->task;

        // Can delete if: task owner OR project leader
        return $task->assigned_to === $user->id ||
               $this->isProjectLeader($user, $task->project_id);
    }

    private function isProjectLeader(User $user, $projectId)
    {
        return $user->projectMembers()
            ->where('project_id', $projectId)
            ->where('role', 'leader')
            ->exists();
    }

}
