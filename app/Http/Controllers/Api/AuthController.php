<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(UserRequest $request){

        $fields = $request->validated();

        $fields['password'] = Hash::make($fields['password']);

        $user = User::create($fields);

        $token = $user->createToken($fields['first_name']);

        return [
            'user'  => $user,
            'token' => $token->plainTextToken
        ];
    }


    public function login(UserRequest $request){

        $fields = $request->validated();

        $user =  User::where('email', $fields['email'])->first();

          if (!$user|| !Hash::check($fields['password'], $user->password)) {

          return response()->json([
             'error' => 'The provided credentials are incorrect.',
             ], 401);

             }

        $token = $user->createToken($fields['email']);


         return [
            'user'  => $user,
            'token' => $token->plainTextToken
             ];

    }



    public function logout(Request $request){

        $user = User::find(1);

        $user->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];

    }
}
