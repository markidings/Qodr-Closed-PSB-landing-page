<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;

use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser; 

class UserController extends Controller
{

    public function __construct()
    {

        // authorize role
        $adminSystem = Role::ADMIN_SYSTEM;
        $this->middleware("role:{$adminSystem}");
    }

    public function index()
    {
        $user = User::where('role','<>','partner')->get();
        return view('user.index', compact('user'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(StoreUser $request)
    {
        $newUser = $request->validated();
        User::create($newUser);

        flash('Data berhasil ditambahkan.', 'success');
        return redirect()->route('user.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::where('id', $id)->get();
        return view('user.edit', compact('user'));
    }

    public function update(UpdateUser $request, $id)
    {
        if ($request->password) {
            $newuser = $request->validated();
        }
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'is_verified' => 'required|in:0,1',
        ]);

        User::where('id', $id)->update($validatedData);

        flash('Data berhasil diperbarui', 'success');

        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        User::destroy(['id' => $id]);

        flash('Data berhasil dihapus.', 'success');
        return redirect()->back();
    }
}
