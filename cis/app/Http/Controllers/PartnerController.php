<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;
use App\Models\City;

use App\Http\Requests\Partner\StorePartner;
use App\Http\Requests\Partner\UpdatePartner;

use App\Services\PartnerService;

class PartnerController extends Controller
{
    protected $partnerService;

    public function __construct()
    {
        $this->partnerService = new PartnerService();

        // authorize role
        $adminSystemRole = Role::ADMIN_SYSTEM;
        $this->middleware("role:{$adminSystemRole}");
    }

    public function index()
    {
        $partners = User::with('meta', 'city')->where('role', Role::PARTNER)->get();

        return view('partner.index', compact('partners'));
    }

    public function create()
    {
        $cities = City::all();

        return view('partner.create', compact('cities'));
    }

    public function store(StorePartner $request)
    {
        $newPartner = $request->validated(); 
        $newPartner['role'] = Role::PARTNER; 

        // save photo
        $metaNewPartner = $this->partnerService->saveMetaPhotos($request, $newPartner);

        $partner = User::create($newPartner);
        $metaPartner = $partner->meta()->create($metaNewPartner);

        flash('Data berhasil ditambahkan.', 'success');

        return redirect()->route('partners.index');
    }

    public function edit(User $partner) 
    {
        $cities = City::all();

        return view('partner.edit', compact('cities', 'partner'));
    }

    public function update(UpdatePartner $request, User $partner)
    {
        $newPartner = $request->validated();
        if (!$newPartner['password']) unset($newPartner['password']);

        // save photo 
        $metaNewPartner = $this->partnerService->saveMetaPhotos($request, $newPartner);

        $partner->update($newPartner);
        $partner->meta()->update($metaNewPartner);

        flash('Data berhasil diperbarui.', 'success');

        return redirect()->route('partners.index');
    }

    public function destroy(User $partner)
    {
        $partner->delete();

        flash('Data berhasil dihapus.', 'success');

        return redirect()->back();
    }
}
