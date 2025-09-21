<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{

    public function index(){
      $users = User::with(['projects', 'projectMembers','tasks'])
      ->where('role', '!=', 'admin')
      -> get();


     return response()->json($users);
    }


}
