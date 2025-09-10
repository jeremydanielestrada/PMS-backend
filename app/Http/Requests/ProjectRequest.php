<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
            if(request()->routeIs('projects.store')){
                return[
                    'name'       => 'required|string|max:255',
                    'owner_id'   => 'required|exists:users,id',
                    'description'=> 'nullable|string',
                    'due_date'   => 'nullable|date|after_or_equal:today',
                ];
            }else if(request()->routeIs('projects.update')){
                return[
                    'name'       =>'sometimes|required|string|max:255',
                    'owner_id'   => 'sometimes|exists:users,id',
                    'description'=>'sometimes|nullable|string',
                    'due_date'   =>'sometimes|nullable|date|after_or_equal:today',
                ];
            }


            return [];
    }
}
