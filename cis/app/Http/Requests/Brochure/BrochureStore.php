<?php

namespace App\Http\Requests\Brochure;

use Illuminate\Foundation\Http\FormRequest;

class BrochureStore extends FormRequest  
{
    public function authorize()
    {
        return true;
    } 

    public function rules()
    {
        return [
            'city_id' => 'required',
            'brochure_image' => 'required|image|max:2048',
        ];
    }
}
