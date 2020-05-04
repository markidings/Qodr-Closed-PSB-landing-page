<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfitReseller extends Model
{
    protected $fillable = ['reseller_id','profit_nominal', 'profit_percent', 'reseller_income'];
}
