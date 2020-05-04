<?php

namespace App\Http\Controllers;

use App\Models\User;

class DetailMitraController extends Controller
{
    public function index($id)
    {
        $partner = User::with('meta', 'city')->find($id);
        return view('detail-mitra.index', compact('partner'));
    }
}
