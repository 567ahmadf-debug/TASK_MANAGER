<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'phone' => 'required|min :10 |max:10',
            'address'=>'required', 
            'date_of_birth' ,
            'bio' => "required|max:100" , 
            'image' =>'required|image|mimes:png,jpg,gif|max :2048' 
        ];
    }

    public function messages(){
        return [
            'phone.max' => "اكتب عشرة ارقام يا بغل" , 
            'phone.min' => "اكتب عشرة ارقام يا بغل" ,
            'bio.max'=>"يا حبيبي يا محترم لا تكتر حكي "
        ] ;
    }
}
