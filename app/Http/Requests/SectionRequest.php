<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'section_name'=>'required|unique:sections,section_name',
            'description'=>'required|unique:sections,description',
        ];
    }

    public function messages()
    {
        return [
            'section_name.unique'=>'لازم يكون الاسم غير مكرر',
            'section_name.required'=>'لازم يكون الاسم موجود',
            'description.required'=>'لازم يكون الوصف موجود',
            'description.unique'=>'لازم يكون الوصف غير مكررد',
        ];
    }
}
