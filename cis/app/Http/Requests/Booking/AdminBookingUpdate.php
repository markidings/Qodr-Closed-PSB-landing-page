<?php

namespace App\Http\Requests\Brochure;

use Illuminate\Foundation\Http\FormRequest;

class AdminBookingUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required',
            'user_id' => 'required',
            'old' => 'required',
            'brochure_photo' => 'image|max:2048'
        ];
    }
}
