<?php

namespace App\Http\Requests\Reseller;

use Illuminate\Foundation\Http\FormRequest;

class ResellerStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'bank_name' => 'required',
            'bank_account' => 'required',
            'no_whatsapp' => 'required',
        ];
    }
}
