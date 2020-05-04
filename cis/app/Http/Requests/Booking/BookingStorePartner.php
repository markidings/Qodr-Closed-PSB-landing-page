<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class BookingStorePartner extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'packet_id' => 'required',
            'user_email' => 'required',
            'total_booking' => 'required',
            'address' => 'required',
            'city_id' => 'required',
            'time_slaughter' => 'required',
            'no_whatsapp' => 'required  | numeric',
            'name_aqiqah' => 'required',
            'name_father' => 'required',
            'name_mother' => 'required',
            'shipping_charge' => 'required',
            'total_purchase' => 'required',
            'name' => 'required',
            'user_id' => 'required',
            // 'postal_code' => 'required',
            'type_purchase' => 'required'
        ];
    }
}
