<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    protected $table = 'prospects';

    protected $fillable = [
        'name',
        'estimated_date',
        'phone_number',
        'status'
    ];

    public function getFormattedEstimatedDateAttribute()
    {
        return date('j F Y', strtotime($this->estimated_date));
    }

    public function getStatusBadgeAttribute() {
        if ($this->status === 'delay') {
            return '<span class="badge badge-pill badge-primary">Delay</span>';
        }

        return '<span class="badge badge-pill badge-success">Sukses</span>';
    }
}
