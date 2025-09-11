<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubTask;
use App\Http\Requests\SubTaskRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SubTaskController extends Controller
{

    use AuthorizesRequests;

    public function index()
    {
        $subtasks = SubTask::with('task')->get();

        return response()->json($subtasks);
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

        $subtask->update($fields);

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
