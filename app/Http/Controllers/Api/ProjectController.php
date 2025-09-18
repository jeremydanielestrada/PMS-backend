<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\ProjectMember;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Project::query()->with(['user', 'project_members']);

        if ($request->has('q')) {
                $search = $request->input('q');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
                });

            }


        $projects = $query->paginate($request->get('per_page',10));

        return response()->json($projects);
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

        ProjectMember::create([
                'project_id' => $project->id,
                'user_id' => $fields['owner_id'],
                'role' => 'leader'
        ]);

        return response()->json($project, 201);
    }


    public function show(string $id)
    {
        $project = Project::with(['project_members', 'user'])->findOrFail($id);


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
