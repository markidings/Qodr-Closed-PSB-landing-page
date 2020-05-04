<?php

namespace App\Http\Requests\Partner;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartner extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $this->partner->id,
            'address' => 'required',
            'city_id' => 'required',
            'password' => 'nullable|min:5|confirmed',
            'is_verified' => 'required|in:0,1',
            'no_whatsapp' => 'nullable',

            'profile_photo' => 'image|max:2048',
            'office_photo' => 'image|max:2048',
            'kitchen_photo' => 'image|max:2048',
            'shed_photo' => 'image|max:2048'
        ];
    }
}
