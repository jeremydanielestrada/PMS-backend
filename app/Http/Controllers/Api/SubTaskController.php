<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\SubTask;
use App\Http\Requests\SubTaskRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SubTaskController extends Controller
{

    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = SubTask::with(['task']);

        // Filter by task if specified
        if ($request->has('task_id')) {
            $query->where('task_id', $request->task_id);
        }

        // Non-admins only see subtasks from their tasks/projects
        if (!auth()->user()->isAdmin()) {
            $userProjectIds = auth()->user()->projectMembers()->pluck('project_id');
            $query->whereHas('task', function($q) use ($userProjectIds) {
                $q->whereIn('project_id', $userProjectIds)
                  ->orWhere('assigned_to', auth()->id());
            });
        }

        return response()->json($query->get());
    }




    public function store(SubTaskRequest $request)
    {
        $fields = $request->validated();

        $this->authorize('create',SubTask::class);

        $subtask = SubTask::create($fields);

        return response()->json(
                   [
                          $subtask, 'message' => 'Created subtask succesfully'
                         ]);
    }


    public function show(string $id)
    {
        $subtask = SubTask::with('task')->findOrFail($id);

        $this->authorize('view',$subtask);


        return response()->json($subtask);

    }




    public function update(SubTaskRequest $request, string $id)
    {
        $subtask = SubTask::findOrFail($id);

         $this->authorize('update',$subtask);

        $fields = $request->validated();

        $subtask->update($fields->only(['title', 'description', 'is_completed']));

        return response()->json($subtask->load('task'));
    }

     public function toggleComplete(SubTask $subtask)
    {
        $this->authorize('update', $subtask);

        $subtask->update(['is_completed' => !$subtask->is_completed]);

        return response()->json($subtask);
    }



    public function destroy(string $id)
    {
         $subtask = SubTask::findOrFail($id);

         $this->authorize('delete',$subtask);

         $subtask->delete();

         return response()->json('Subtask deleted');
    }
}
