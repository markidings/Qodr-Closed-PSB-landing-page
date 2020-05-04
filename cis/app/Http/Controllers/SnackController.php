<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Snack\StoreSnack;
use App\Http\Requests\Snack\UpdateSnack;

use App\Models\Snack;
use App\Models\Role;

class SnackController extends Controller
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
        $snacks = Snack::with('partner')->where('user_id', $partnerID)->get();

        return view('snack.index', compact('snacks'));
    }

    public function create()
    {
        return view('snack.create');
    }

    public function store(StoreSnack $request)
    {
        $newSnack = $request->validated();
        $newSnack['user_id'] = auth()->user()->id;

        // save photo
        if ($request->hasFile('photo')) {
            $photoPath = $newSnack['photo']->store('public/images/snacks');
            $newSnack['photo_file'] = $photoPath;
        }

        $snack = Snack::create($newSnack);

        flash('Data berhasil ditambahkan.', 'success');

        return redirect()->route('snacks.index');
    }

    public function edit(Snack $snack)
    {
        return view('snack.edit', compact('snack'));
    }

    public function update(UpdateSnack $request, Snack $snack)
    { 
        $updatedSnack = $request->validated();

        // save photo
        if ($request->hasFile('photo')) {
            $photoPath = $updatedSnack['photo']->store('public/images/snacks');
            $updatedSnack['photo_file'] = $photoPath;
        }

        $snack->update($updatedSnack);

        flash('Data berhasil diperbarui.', 'success');

        return redirect()->route('snacks.index');
    }

    public function destroy(Snack $snack)
    {
        $snack->delete();

        flash('Data berhasil dihapus.', 'success');

        return redirect()->back();
    }
}
