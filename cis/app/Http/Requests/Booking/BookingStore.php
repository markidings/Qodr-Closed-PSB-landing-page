<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class BookingStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'city_id' => 'required',
            'no_whatsapp' => 'required  | numeric',
            'name' => 'required',
            'packet_id' => 'required'
        ];
    }
}
