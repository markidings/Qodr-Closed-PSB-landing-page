<?php

namespace App\Http\Controllers;

use App\Models\ProfitMitra;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Paket;
use Illuminate\Support\Facades\DB;

class ProfitMitraController extends Controller
{
    public function index()
    {
        $pakets = Paket::with('profitMitra')->get();

        return view('profit-mitra/list-mitra', ['pakets' => $pakets]);
    }

    public function listpaket($id)
    {
        $pakets = Paket::where('id', $id)->with('city', 'profitMitra')->get();

        return view('profit-mitra/list-paket', ['pakets' => $pakets]);
    }

    public function list()
    {
        $users = User::where('role', 'partner')->with('paket')->get();

        return view('profit-mitra/list-mitra', ['users' => $users]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $id = $request->paket_id;
        $paket = Paket::where('id', $id)->first();

        $incomemale = $paket->harga - $request->profit_male;
        $incomefemale = $paket->price - $request->profit_female;

        ProfitMitra::Create([
            'paket_id' => $request->paket_id,
            'profit_male' => $request->profit_male,
            'percent_male' => $request->percent_male,
            'income_male' => $incomemale,
            'profit_female' => $request->profit_female,
            'percent_female' => $request->percent_female,
            'income_female' => $incomefemale,
        ]);

        flash('Data berhasil ditambah.', 'success');

        return redirect("/dashboard/detailpaket/$id");
    }

    public function show(ProfitMitra $profitMitra)
    {
        //
    }

    public function edit(ProfitMitra $profitMitra)
    {
        //
    }

    public function update($id, Request $request, ProfitMitra $profitMitra)
    {
        $paket = Paket::where('id', $id)->first();
        
        $incomemale = $paket->harga - $request->profit_male;
        $incomefemale = $paket->price - $request->profit_female;

        $b = ProfitMitra::where('paket_id', $id)->first();
        $b->profit_male = $request->profit_male;
        $b->percent_male = $request->percent_male;
        $b->income_male = $incomemale;
        $b->profit_female = $request->profit_female;
        $b->percent_female = $request->percent_female;
        $b->income_female = $incomefemale;
        $b->save();
        flash('Data berhasil diperbarui.', 'success');
        return redirect("/dashboard/detailpaket/$id");
    }

    public function destroy(ProfitMitra $profitMitra)
    {
        //
    }
}
