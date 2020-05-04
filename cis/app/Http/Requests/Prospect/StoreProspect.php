<?php

namespace App\Http\Requests\Prospect;

use Illuminate\Foundation\Http\FormRequest;

class StoreProspect extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'estimated_date' => 'required|date',
            'phone_number' => 'required',
            'status' => 'required|in:delay,success',
        ];
    }
}
