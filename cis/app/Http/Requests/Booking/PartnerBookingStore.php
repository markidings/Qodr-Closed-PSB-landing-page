<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class PartnerBookingStore extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'paket' => 'required',
            'packet_id' => 'required',
            'user_email' => 'required',
            'total_booking' => 'required',
            'address' => 'required',
            'city_id' => 'required',
            'time_slaughter' => 'required',
            'no_whatsapp' => 'required',
            'name_aqiqah' => 'required',
            'name_father' => 'required',
            'name_mother' => 'required',
            'shipping_charge' => 'required',
            'name' => 'required',
            'user_id' => 'required',
            'postal_code' => 'required',
            'type_purchase' => 'required',
            'type_payment' => 'required',
            'no_whatsapp' => 'required | numeric',
            'status_transaction' => 'required',
            'total_purchase' => 'required',
            'type_goat' => 'required|in:male,female'
        ];
    }
}