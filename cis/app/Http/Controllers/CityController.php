<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();

        return view('city.index', compact('cities'));
    }

    public function create()
    {
        return view('city.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required'
        ]); 

        City::create($validatedData);

        flash('Data berhasil ditambahkan', 'success');

        return redirect()->route('cities.index'); 
    }

    public function edit(City $city)
    {
        return view('city.edit', compact('city'));
    }

    public function update(Request $request, City $city)
    {
        $validatedData = $request->validate([
            'name' => 'required'
        ]);

        $city->update($validatedData);

        flash('Data berhasil diperbarui', 'success');

        return redirect()->route('cities.index');
    }

    public function destroy(City $city)
    {
        $city->delete();

        flash('Data berhasil dihapus.', 'success');

        return redirect()->back();
    }
}
