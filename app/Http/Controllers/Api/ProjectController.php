<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Project::All();
    }




    public function store(ProjectRequest $request)
    {
        $fields = $request->validated();

        $fields['owner_id'] = $fields['owner_id'] ?? auth()->id(); //safe error, waiting for user auth

        $project = Project::create($fields);

        return response()->json($project, 201);
    }


    public function show(string $id)
    {
        $project = Project::findOrFail($id);

        return response()->json($project);
    }




    public function update(ProjectRequest $request, string $id)
    {

        $project = Project::findOrFail($id);

        $fields = $request->validated();

        $project->update($fields);


        return response()->json($project, 200);


    }


    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        return response()->json($project,200);
    }
}
