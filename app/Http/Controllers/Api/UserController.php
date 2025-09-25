<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index(Request $request){

        $search = $request->query('search');
        $perPage = $request->query('per_page', 10);

      $users = User::with(['projects', 'projectMembers','tasks'])
      ->where('role', '!=', 'admin')
      -> when($search, function($query, $search){
        $query->where('first_name', 'like', "%{$search}%")
               ->orWhere('email', 'like', "%{$search}%");
          }
       )->paginate($perPage);


     return response()->json($users);
    }




    //get data of auth users
    public function authUser(){
    $user = User::with(['projects', 'tasks', 'projectMembers'])
        ->find(auth()->id());

    return response()->json($user);
}


}
