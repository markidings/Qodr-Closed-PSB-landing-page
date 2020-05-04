<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    protected $fillable = ['name','bank_account', 'no_whatsapp', 'bank_name'];
}
