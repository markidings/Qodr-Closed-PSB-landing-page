<?php

namespace App\Http\Controllers;

use App\Models\ProfitReseller;
use Illuminate\Http\Request;

class ProfitResellerController extends Controller 
{
    /**
     * Display a listing of the resource. 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profitReseller = ProfitReseller::find(1);

        return view('profit-reseller.index', compact('profitReseller')); 
        // return view('profit-reseller/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        ProfitReseller::Create([
            // 'paket_id' => $request->paket_id,
            'profit_nominal' => $request->profit_nominal,
            'profit_percent' => $request->profit_percent,
            // 'selling_price' => $request->harga_jual,
        ]);
        

        // ShippingCostPartner::updateOrCreate($shippingCostData);

        flash('Data berhasil ditambah.', 'success');
        return redirect()->route('profitReseller');

        // return redirect("/dashboard/detailpaket/$id");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProfitReseller  $profitReseller
     * @return \Illuminate\Http\Response
     */
    public function show(ProfitReseller $profitReseller)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfitReseller  $profitReseller
     * @return \Illuminate\Http\Response
     */
    public function edit(ProfitReseller $profitReseller)
    {
        $profitReseller = ProfitReseller::find(1);

        return view('profit-reseller.edit', compact('profitReseller')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProfitReseller  $profitReseller
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, ProfitReseller $profitReseller)
    {
        $b = ProfitReseller::where('id', $id)->first();
        $b->profit_nominal = $request->profit_nominal;
        $b->profit_percent = $request->profit_percent;
        $b->save();
        flash('Data berhasil diperbarui.', 'success');
        
        return redirect()->route('profitReseller');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfitReseller  $profitReseller
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfitReseller $profitReseller)
    {
        //
    }
}
