<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    const AVAILABLE_ROLES = [
        'ADMIN_CS' => 'admin_cs',
        'PARTNER' => 'partner',
        'ADMIN_FINANCE' => 'admin_finance',
        'ADMIN_SYSTEM' => 'admin_system'
    ];

    protected $fillable = [
        'email',
        'password',
        'is_verified',
        'role',
        'name',
        'address',
        'city_id',
        'no_whatsapp'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getNoWaAttribute()
    {
        return "+62{$this->no_whatsapp}";
    }

    // relations
    public function meta()
    {
        return $this->hasOne(MetaPartner::class, 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function snacks()
    {
        return $this->hasMany(Snack::class, 'user_id');
    }

    public function brochure()
    {
        return $this->hasMany(Brochure::class);
    }

    public function partner_shipping_cost()
    {
        return $this->hasOne(ShippingCostPartner::class, 'partner_id');
    }

    public function message_templates()
    {
        return $this->hasMany(MessageTemplate::class, 'partner_id');
    }

    public function paket()
    {
        return $this->hasMany(Paket::class);
    }

    public function booking(){
        return $this->hasMany(Booking::class);
    }

    public function adminPacket()
    {
        return $this->hasMany(AdminPacket::class);
    }

    public function profitMitra()
    {
        return $this->hasMany(ProfitMitra::class);
    }

    // helpers
    public function isPartner()
    {
        return $this->role === Role::PARTNER;
    }

    public function isAdminSystem()
    {
        return $this->role === Role::ADMIN_SYSTEM;
    }

    public function isAdminCS()
    {
        return $this->role === Role::ADMIN_CS;
    }
}
