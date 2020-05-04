<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Broadcast extends Model
{
    protected $table = 'message_histories';

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
