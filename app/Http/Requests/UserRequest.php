<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        if(request()->routeIs('user.register')){

         return [
               'first_name'     => 'required|string|max:255',
               'last_name'      => 'required|string|max:255',
               'email'          => 'required|email|max:255|unique:users',
               'password'       => 'required|string|confirmed|min:8',
               'role'           => 'required|string',
               'profile_img'    => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
               ];

        }else if(request()->routeIs('user.login')){
         return [
                'email'    => 'required|email',
                'password' => 'required|string',
             ];
        }


        return [];

    }
}
