<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageHistory extends Model
{
    protected $fillable = ['type', 'message', 'phone_number'];
}
