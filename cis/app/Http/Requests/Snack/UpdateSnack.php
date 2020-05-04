<?php

namespace App\Http\Requests\Snack;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSnack extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',

            'photo' => 'image|max:2048',
        ];
    }
}
