<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class BookingUpdate extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_email' => 'required',
            'total_booking' => 'required',
            'address' => 'required',
            'city_id' => 'required',
            'time_slaughter' => 'required',
            'no_whatsapp' => 'required | numeric',
            'name_mother' => 'required',
            'name_aqiqah' => 'required',
            'name_father' => 'required',
            'name' => 'required',
            'postal_code' => 'required',
            'type_purchase' => 'required|in:full,dp',
            'type_goat' => 'required|in:male,female'
        ];
    }
}
