<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Project::with('user')->get();
    }




    public function store(ProjectRequest $request)
    {
        $fields = $request->validated();

        $this->authorize('create', Project::class); //Only the admin  can create a project

       // If admin provided owner_id, use it; otherwise use current user
         $fields['owner_id'] = (auth()->user()->role === 'admin' && isset($fields['owner_id']))
        ? $fields['owner_id']
        : auth()->id();

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

        $this->authorize('update',$project);

        $fields = $request->validated();

        $project->update($fields);


        return response()->json($project, 200);


    }


    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        $this->authorize('delete',$project);

        $project->delete();

        return response()->json(['Successfully Deleted']);
    }
}
