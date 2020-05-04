<?php

namespace App\Http\Requests\Brochure;
 
use Illuminate\Foundation\Http\FormRequest;

class AdminBookingStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required',
            'brochure_photo' => 'image|max:2048'
        ];
    }
}
