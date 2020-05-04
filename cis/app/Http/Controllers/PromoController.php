<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Promo\StorePromo;
use App\Http\Requests\Promo\UpdatePromo;

use App\Models\Promo;
use App\Models\Role;

class PromoController extends Controller
{
    public function __construct()
    {
        // authorize role
        // $adminSystemRole = Role::ADMIN_SYSTEM;
        // $partnerRole = Role::PARTNER;
        // $this->middleware("role:$adminSystemRole");
    }

    public function index()
    {
        $partnerID = auth()->user()->id;
        $promos = Promo::where('user_id', $partnerID)
            ->orderBy('updated_at', 'DESC')
            ->get();

        return view('promo.index', compact('promos'));
    }

    public function create()
    {
        return view('promo.create');
    }

    public function store(StorePromo $request)
    {
        $newPromo = $request->validated();
        $newPromo['user_id'] = auth()->user()->id;

        $promo = Promo::create($newPromo);

        flash('Data berhasil ditambahkan', 'success');

        return redirect()->route('promos.index');
    }

    public function edit(Promo $promo)
    {
        return view('promo.edit', compact('promo'));
    }

    public function update(UpdatePromo $request, Promo $promo)
    {
        $updatedPromo = $request->validated();

        $promo->update($updatedPromo);

        flash('Data berhasil diperbarui.', 'success');

        return redirect()->route('promos.index');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();

        flash('Data berhasil dihapus.', 'success');

        return redirect()->back();
    }
}
