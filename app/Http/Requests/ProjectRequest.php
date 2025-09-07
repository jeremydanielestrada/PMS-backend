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
            if(request()->routeIs('project.store')){
                return[
                    'owner_id'   => 'required|integer|exists:users,id',
                    'name'       => 'required|string|max:255',
                    'description'=> 'nullable|string',
                    'due_date'   => 'nullable|date|after_or_equal:today',
                ];
            }else{
                return[
                    'owner_id'   => 'sometimes|integer|exists:users,id',
                    'name'       =>'sometimes|required|string|max:255',
                    'description'=>'sometimes|nullable|string',
                    'due_date'   =>'sometimes|nullable|date|after_or_equal:today',
                ];
            }
    }
}
