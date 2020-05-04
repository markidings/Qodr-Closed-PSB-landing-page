<?php

namespace App\Http\Requests\MessageTemplate;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageTemplate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'type' => 'required|in:broadcast,report',
            'message' => 'required',
        ];
    }
}
