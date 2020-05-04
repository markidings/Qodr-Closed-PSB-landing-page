<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCostPartner extends Model 
{
    protected $table = 'partner_shipping_costs';

    protected $fillable = [
        'partner_id',
        'in_city_cost',
        'out_city_cost'
    ];

    public function getInCityCostTextAttribute()
    {
        return "Rp {$this->in_city_cost}";
    }

    public function getOutCityCostTextAttribute()
    {
        return "Rp {$this->out_city_cost}";
    }
}
