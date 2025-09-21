<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Task::with([ 'project', 'assignedUser']);

        // Filter by project if specified
        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Non-admins only see tasks from their projects
        if (!auth()->user()->isAdmin()) {
            $userProjectIds = auth()->user()->projectMembers()->pluck('project_id');
            $query->whereIn('project_id', $userProjectIds);
        }

        return response()->json($query->get());
    }



    public function store(TaskRequest $request)
    {
        $fields = $request->validated();

        $this->authorize('create',Task::class);

        $task = Task::create($fields);

        return response()->json($task, 201);
    }




    public function show(string $id)
    {
        $task = Task::with(['assignedUser','project'])->findOrFail($id);

        return response()->json($task, 200);
    }



    public function update(TaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        $fields = $request->validated();

        // Only admins and project leaders can reassign tasks
        if (isset($fields['assigned_to']) && $fields['assigned_to'] !== $task->assigned_to) {
            if (!auth()->user()->isAdmin() && !$this->isProjectLeader(auth()->user(), $task->project_id)) {
                unset($fields['assigned_to']);
            }
        }

        $task->update($fields);

        return response()->json($task->load([ 'project', 'assignedUser']));
    }



    public function updateStatus(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $request->validate([
            'status' => 'required|in:todo,in_progress,done'
        ]);

        $task->update(['status' => $request->status]);

        return response()->json($task);
    }



    public function destroy(string $id)
    {
          $task = Task::findOrFail($id);

          $this->authorize('delete',$task);

          $task->delete();


          return response([
            $task,
            'message' => 'Succesfully Deleted Task'
          ]);
    }

    private function isProjectLeader(User $user, $projectId)
    {
        return $user->projectMembers()
            ->where('project_id', $projectId)
            ->where('role', 'leader')
            ->exists();
    }



}
