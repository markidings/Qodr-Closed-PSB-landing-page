<?php

namespace App\Http\Requests\Brochure;

use Illuminate\Foundation\Http\FormRequest;

class BrochureUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }
 
    public function rules()
    { 
        return [
            'id' => 'required',
            'city_id' => 'required',
            'brochure_image' => 'image|max:2048'
        ];
    }
}
