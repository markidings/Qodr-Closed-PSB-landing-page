<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Booking extends Model
{
    const STATUS_PURCHASE_DP = 'dp';
    const STATUS_PURCHASE_FULL = 'full';
    // protected $table = 'bookings';
    protected $fillable = [

        'packet_id', 'user_email', 'total_booking', 'address', 'city_id', 'no_whatsapp', 'name_aqiqah',
        'name_father', 'name_mother', 'address_packet', 'time_packet', 'snack_id', 'type_booking', 'shipping_charge', 'total_purchase',
        'name', 'user_id','postal_code', 'status', 'no_nota', 'type_purchase', 'time_slaughter','promo_id',
        'status_purchase','partner_shipping_cost','status_transaction','type_payment'
    ];
    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'mitra_id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function packet()
    {
        return $this->belongsTo(Paket::class);
    }
    public function profitMitra()
    {
        return $this->hasOne(ProfitMitra::class);
    }


    public function purchase_confirm()
    {
        return $this->hasOne(PurchaseConfirm::class);
    }


    public function scopeStatus1($query)
    {
        return $query->where('status', 1);
    }
    public function scopeStatus0($query)
    {
        return $query->where('status', 0);
    }
    public function scopeMitra($query)
    {
        $userId = Auth::id();
        return $query->where('user_id', $userId);
    }
    public function getFormattedDateAttribute()
    {
        return date('j F Y', strtotime($this->time_slaughter));
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function snack()
    {
        return $this->belongsTo(Snack::class);
    }
    
    public function getStatusTimeAttribute()
    {
        if(date("Y-m-d", strtotime("-1 day", strtotime($this->time_slaughter))) <= date("Y-m-d")){
            return 'style="color:red"';
        }else{
            return 'style=""';
        }
    }
    
    public function getStatusTimeIndexAttribute()
    {
        if(date("Y-m-d", strtotime("+2 day", strtotime($this->created_at))) <= date("Y-m-d")){
            return 'style="color:red"';
        }else{
            return 'style=""';
        }
    }
}
