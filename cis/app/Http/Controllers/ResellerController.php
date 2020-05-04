<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Reseller;

use App\Http\Requests\Reseller\ResellerStore;
use App\Http\Requests\Reseller\ResellerUpdate;
use File;


class ResellerController extends Controller
{
    public function index()
    {
        $resellers = Reseller::all();

        return view('reseller/index',['resellers' => $resellers]);
    }

    public function create()
    {

        return view('reseller/create');
    }

    public function store(ResellerStore $request) 
    {

        Reseller::create([
            'name' => $request->name,
            'bank_name' => $request->bank_name,
            'bank_account' => $request->bank_account,
            'no_whatsapp' => $request->no_whatsapp,
        ]);

        flash('Data berhasil ditambahkan.', 'success');

        return redirect()->route('resellers.index');
    }

    public function edit(Reseller $reseller)
    {
        return view('reseller.edit', compact('reseller'));
    }

    public function update(ResellerUpdate $request)
    {
        $b = Reseller::find($request->id);
        $b->name = $request->name;
        $b->bank_name = $request->bank_name;
        $b->bank_account = $request->bank_account;
        $b->no_whatsapp = $request->no_whatsapp;
        $b->save();

        flash('Data berhasil diperbarui.', 'success');

        return redirect()->route('resellers.index');
    }

    public function destroy($id)
    {
        Reseller::destroy(['id'=>$id]);

        flash('Data berhasil dihapus.', 'success');
        return redirect()->route('resellers.index');
    }
}
