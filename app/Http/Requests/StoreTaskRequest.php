<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|unique:tasks,title|max:40',
            'description' => 'required|string',
            'priority' => 'required|in : high , mid ,low'  , 
            ];
    }

    public function messages()
    {
        return[
            'title.unique' => 'هش يا بغل',
            'priority.integer' => 'هش يا حمار'        
            ] ;
    }
}
