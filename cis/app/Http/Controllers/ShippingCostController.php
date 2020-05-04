<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ShippingCostPartner;
use App\Models\Role;

class ShippingCostController extends Controller
{
    public function __construct()
    {
        // authorize role
        $partnerRole = Role::PARTNER;
        $this->middleware("role:{$partnerRole}");
    }

    public function index()
    {
        $partnerID = auth()->user()->id; 
        $shippingCost = auth()->user()->partner_shipping_cost;

        return view('shipping-cost.index', compact('shippingCost'));
    }

    public function edit()
    {
        $partnerID = auth()->user()->id;
        $shippingCost = ShippingCostPartner::find($partnerID);

        return view('shipping-cost.edit', compact('shippingCost')); 
    }

    public function update(Request $request) 
    {
        $partner = auth()->user();
        $shippingCostData = $request->all();
        $shippingCostData['partner_id'] = $partner->id;

        ShippingCostPartner::updateOrCreate([
            'partner_id' => $partner->id,
        ], $shippingCostData);

        flash('Data berhasil diperbarui.', 'success');

        return redirect()->route('shipping-cost');
    }
}
