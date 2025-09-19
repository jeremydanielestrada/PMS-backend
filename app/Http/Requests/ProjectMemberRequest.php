<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectMemberRequest extends FormRequest
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

        if(request()->routeIs('project-members.store')){

        return [
            'project_id' => 'required|exists:projects,id',
            'user_id'    => 'required|exists:users,id',
            'role'       => 'required|string|max:255',
               ];

        }else if (request()->routeIs('project-members.update')){

        return [
            'project_id' => 'sometimes|exists:projects,id',
            'user_id'    => 'sometimes|exists:users,id',
            'role'       => 'sometimes|string|max:255',
               ];

        }


        return[];

    }
}
