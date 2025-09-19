<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Http\Requests\ProjectMemberRequest;
use App\Http\Requests\ProjectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Exception;
use Illuminate\Support\Facades\Log;

class ProjectMemberController extends Controller
{
    use AuthorizesRequests;
    public function index(){

            $project_member =  ProjectMember::with(['project', 'user'])->get();

            return response()->json($project_member,200);

    }




    public function store(ProjectMemberRequest $request){

            try{

             $fields = $request->validated();


             $this->authorize('create', ProjectMember::class);

            //  $fields['user_id'] = $fields['user_id'] ?? auth()->id();

             $project_member = ProjectMember::create($fields);

             return response()->json($project_member, 200);

            }catch(Exception $e){

            Log::error('Project Member Creation Failed', [
                'error' => $e->getMessage(),
                'fields' => $fields ?? null
            ]);

             return response()->json([
            'error' => 'Failed to create project',

            'message' => $e->getMessage()

            ], 500);


            }



    }


    public function show(string $id){

           $project_member = ProjectMember::findOrFail($id);

           return response()->json($project_member );

    }



    public function update(ProjectRequest $request, string $id){

             $project_member = ProjectMember::findOrFail($id);

             $this->authorize('update',$project_member);

              $fields = $request->validated();

              $project_member->update($fields);

              return response()->json($project_member, 200);

    }


    public function destroy(string $id){

            $project_member = ProjectMember::findOrFail($id);

            $this->authorize('delete', $project_member);

            $project_member->delete();

            return response()->json(['Successfully deleted']);

    }



}
