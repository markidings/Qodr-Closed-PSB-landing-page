<?php

namespace App\Http\Requests\Promo;

use Illuminate\Foundation\Http\FormRequest;

class StorePromo extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|unique:promos,code',
            'description' => 'present',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'type' => 'required|in:price,percent',
            'discount_amount' => 'required|numeric'
        ];
    }
}
