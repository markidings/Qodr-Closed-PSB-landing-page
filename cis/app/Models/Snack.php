<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Snack extends Model
{
    use SoftDeletes;

    protected $table = 'snacks';

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'description',
        'photo_file'
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo_file) {
            return asset(Storage::url($this->photo_file));
        }

        return asset('images/default/default-snack.png');
    }
}
