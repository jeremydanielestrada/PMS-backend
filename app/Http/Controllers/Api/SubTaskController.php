<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubTask;
use App\Http\Requests\SubTaskRequest;

class SubTaskController extends Controller
{

    public function index()
    {
        $subtasks = SubTask::with('task')->get();

        return response()->json($subtasks);
    }




    public function store(SubTaskRequest $request)
    {
        $fields = $request->validated();

        $subtask = SubTask::create($fields);

        return response()->json(
                   [
                          $subtask, 'message' => 'Created subtask succesfully'
                         ]);
    }


    public function show(string $id)
    {
        $subtask = SubTask::with('task')->findOrFail($id);


        return response()->json($subtask);

    }




    public function update(SubTaskRequest $request, string $id)
    {
        $subtask = SubTask::findOrFail($id);

        $fields = $request->validated();

        $subtask->update($fields);

        return response()->json($subtask);
    }


    public function destroy(string $id)
    {
         $subtask = SubTask::findOrFail($id);

         $subtask->delete();

         return response()->json('Subtask deleted');
    }
}
