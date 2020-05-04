<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Support\Facades\Storage;

    class Brochure extends Model
{
    protected $fillable = ['user_id', 'brochure_image', 'city_id'];

    public function scopeMitra($query)
    {
        $userId = Auth::id();
        return $query->where('user_id', $userId);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getBrochureImageUrlAttribute()
    {
        return asset(Storage::url($this->brochure_image));
    }
}
