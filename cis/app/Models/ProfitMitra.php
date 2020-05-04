<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitMitra extends Model
{
    protected $fillable = ['paket_id','profit_male', 'percent_male', 'income_male', 'profit_female', 'percent_female', 'income_female'];
    //
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    public function paket() 
    {
        return $this->belongsTo(Paket::class);
    }
    public function booking() 
    {
        return $this->belongsTo(Booking::class);
    }
    
}
