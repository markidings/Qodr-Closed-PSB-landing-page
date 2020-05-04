<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest    
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    { 
        return [
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable|min:5|confirmed',
            'is_verified' => 'required|in:0,1',
        ];
    }
}
