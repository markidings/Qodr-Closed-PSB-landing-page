<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Role;
use App\Models\City;

use App\Services\PartnerService;

class ProfilePartnerController extends Controller
{
    protected $partnerService;

    public function __construct()
    {
        $this->partnerService = new PartnerService();

        // authorize role
        $partnerRole = Role::PARTNER;
        $this->middleware("role:{$partnerRole}");
    } 

    public function index()
    {
        $partnerID = auth()->user()->id;
        $partner = User::with('meta', 'city')->find($partnerID);

        return view('profile-partner.index', compact('partner'));
    }

    public function edit()
    {
        $cities = City::all();

        $partnerID = auth()->user()->id;
        $partner = User::with('meta', 'city')->find($partnerID);

        return view('profile-partner.edit', compact('partner', 'cities'));
    }

    public function update(Request $request)
    {
        $partner = auth()->user();
        $partnerID = auth()->user()->id;

        $newPartner = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $partnerID,
            'address' => 'required',
            'city_id' => 'required',
            'password' => 'nullable|min:5|confirmed',
            'no_whatsapp' => 'required',

            'profile_photo' => 'image|max:2048',
            'office_photo' => 'image|max:2048',
            'kitchen_photo' => 'image|max:2048',
            'shed_photo' => 'image|max:2048'
        ]);
        if (!$newPartner['password']) unset($newPartner['password']);

        // save photo
        $metaNewPartner = $this->partnerService->saveMetaPhotos($request, $newPartner);

        $partner->update($newPartner);
        $partner->meta()->update($metaNewPartner);

        flash('Data berhasil diperbarui.', 'success');

        return redirect()->route('profile-partner');
    }
}
