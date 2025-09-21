<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Requests\TaskRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $tasks = Task::with(['user','project'])->get();

        return response()->json($tasks, 200);
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
        $task = Task::with(['user','project'])->findOrFail($id);

        return response()->json($task, 200);
    }



    public function update(TaskRequest $request, string $id)
    {
        $task = Task::findOrFail($id);

        $this->authorize('update',$task);

        $fields = $request->validated();

        $task->update($fields);


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
}
