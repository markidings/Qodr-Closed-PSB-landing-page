<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Auth;

class Promo extends Model
{
    protected $table = 'promos';

    protected $fillable = [
        'user_id',
        'code',
        'description',
        'start_date',
        'end_date',
        'type',
        'discount_amount'
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function booking()
    // {
    //     return $this->belongsTo(Booking::class, 'user_id');
    // }

    public function scopeUserPromo($query)
    {
        $userId = Auth::id();
        return $query->where('user_id', $userId);
    }

    public function getDiscountAmountTextAttribute()
    {
        if ($this->type === 'price') {
            return "Rp {$this->discount_amount}";
        }

        return "{$this->discount_amount} %";
    }
 
    public function getFormattedStartDateAttribute()
    {
        return date('j F Y', strtotime($this->start_date));
    }

    public function getFormattedEndDateAttribute()
    {
        return date('j F Y', strtotime($this->end_date));
    }
}
