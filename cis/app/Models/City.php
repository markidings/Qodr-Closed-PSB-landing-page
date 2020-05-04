<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'cities';

    protected $fillable = [
        'province_id',
        'name'
    ];

    public function bookings()
    {
        return $this->hasMany('App\Models\Booking');
    }

    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }

    public function pakets()
    {
        return $this->hasMany('App\Models\Paket');
    }
}
