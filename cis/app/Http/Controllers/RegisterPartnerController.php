<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Role;
use App\Models\User;

use App\Services\PartnerService;

class RegisterPartnerController extends Controller
{
    protected $partnerService;

    public function __construct()
    {
        $this->partnerService = new PartnerService();
    }

    public function create()
    {
        $cities = City::all();

        return view('register-partner.create', compact('cities'));
    }

    public function store(Request $request)
    {
        $newPartner = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'city_id' => 'required',
            'password' => 'required|min:5|confirmed',
            'no_whatsapp' => 'required',
            'profile_photo' => 'image|max:2048',
            'office_photo' => 'image|max:2048',
            'kitchen_photo' => 'image|max:2048',
            'shed_photo' => 'image|max:2048'
        ]);

        $newPartner['role'] = Role::PARTNER;
        // is_verified = false
        $newPartner['is_verified'] = false;

        // save photo
        $metaNewPartner = $this->partnerService->saveMetaPhotos($request, $newPartner);
        $partner = User::create($newPartner);
        $metaPartner = $partner->meta()->create($metaNewPartner);

        flash('Berhasil registrasi mitra.', 'success');

        return redirect()->route('register-partner');
    }
}
