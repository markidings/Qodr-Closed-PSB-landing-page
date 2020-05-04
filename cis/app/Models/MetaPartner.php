<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MetaPartner extends Model
{
    protected $table = 'meta_partners';

    protected $fillable = [
        'user_id',
        'profile_photo_file',
        'office_photo_file',
        'kitchen_photo_file',
        'shed_photo_file',
    ];

    protected $appends = [
        'profile_photo_url',
        'office_photo_url',
        'kitchen_photo_url',
        'shed_photo_url',
    ]; 

    public function getProfilePhotoUrlAttribute()
    {
        return asset(Storage::url($this->profile_photo_file));
    }

    public function getOfficePhotoUrlAttribute()
    {
        return asset(Storage::url($this->office_photo_file));
    }

    public function getKitchenPhotoUrlAttribute()
    {
        return asset(Storage::url($this->kitchen_photo_file));
    }

    public function getShedPhotoUrlAttribute()
    {
        return asset(Storage::url($this->shed_photo_file));
    }
}
