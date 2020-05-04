<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseConfirm extends Model
{
    use SoftDeletes;

    protected $table = 'purchase_confirmations';

    protected $fillable = [
        'booking_id',
        'no_nota',
        'nominal',
        'paid_off',
        'deposit_status'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function getNominalRupiahAttribute()
    {
        $result = "Rp " . number_format($this->nominal, 2, ',', '.');

        return $result;
    }
}
