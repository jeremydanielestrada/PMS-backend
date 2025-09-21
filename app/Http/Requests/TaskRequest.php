<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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


        if(request()->routeIs('tasks.store')){

            return [
                    'project_id'   => 'required|exists:projects,id',
                    'assigned_to' => 'required|exists:users,id',
                    'title'        => 'required|string|max:255',
                    'description'  => 'nullable|string|max:255',
                    'status'       => 'required|string|max:255',
                    'priority'     => 'required|string|max:255',
                    'due_date'     => 'nullable|date|after_or_equal:today',
                  ];
        }else if(request()->routeIs('tasks.update')){
            return [
                    'project_id'   => 'sometimes|exists:projects,id',
                    'assigned_to' => 'sometimes|exists:users,id',
                    'title'        => 'sometimes|required|string|max:255',
                    'description'  => 'sometimes|nullable|string|max:255',
                    'status'       => 'sometimes|required|string|max:255',
                    'priority'     => 'sometimes|required|string|max:255',
                    'due_date'     => 'sometimes|nullable|date|after_or_equal:today',
                  ];

        }


        return[];


    }
}
