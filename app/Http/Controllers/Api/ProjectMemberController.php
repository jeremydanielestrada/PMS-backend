<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProjectMember;
use App\Http\Requests\ProjectMemberRequest;
use App\Http\Requests\ProjectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectMemberController extends Controller
{
    use AuthorizesRequests;
    public function index(){

            $project_member =  ProjectMember::with(['project', 'user'])->get();

            return response()->json($project_member,200);

    }




    public function store(ProjectMemberRequest $request){


             $fields = $request->validated();


             $fields['user_id'] = $fields['user_id'] ?? auth()->id();

             $project_member = ProjectMember::create($fields);

             return response()->json($project_member, 200);

    }


    public function show(string $id){

           $project_member = ProjectMember::findOrFail($id);

           return response()->json($project_member );

    }



    public function update(ProjectRequest $request, string $id){

             $project_member = ProjectMember::findOrFail($id);

             $this->authorize('update',$project_member);

              $fields = $request->validated();

              $project_member->ProjectMember::update($fields);

              return response()->json($project_member, 200);

    }


    public function destroy(string $id){

            $project_member = ProjectMember::findOrFail($id);

            $this->authorize('delete', $project_member);

            $project_member->delete();

            return response()->json(['Successfully deleted']);

    }



}
