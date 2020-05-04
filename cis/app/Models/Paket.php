<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'mitra_id');
    }


    public function booking()
    {
        return $this->hasMany(Booking::class);
    }
    public function profitMitra()
    {
        return $this->hasOne(ProfitMitra::class);
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }
}
