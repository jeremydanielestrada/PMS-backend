<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubTaskRequest extends FormRequest
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

        if(request()->routeIs('subtasks.store')){

            return [
                    'task_id'       => 'required|exists:tasks,id',
                    'title'         => 'required|string|max:255',
                    'is_completed'  => 'required|boolean',
                  ];
        }else if(request()->routeIs('subtasks.update')){
            return [
                    'task_id'       => 'sometimes|exists:tasks,id',
                    'title'         => 'sometimes|string|max:255',
                    'is_completed'  => 'sometimes|boolean',
                  ];

        }


        return[];
    }
}
