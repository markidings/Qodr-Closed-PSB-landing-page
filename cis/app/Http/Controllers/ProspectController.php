<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\Prospect\StoreProspect;

use App\Models\Prospect;

class ProspectController extends Controller
{
    public function index()
    {
        $prospects = Prospect::all();

        return view('prospect.index', compact('prospects'));
    }

    public function create()
    {
        return view('prospect.create');
    }

    public function store(StoreProspect $request)
    {
        $newProspect = $request->validated();

        Prospect::create($newProspect);

        flash('Data berhasil ditambahkan', 'success');

        return redirect()->route('prospects.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Prospect $prospect)
    {
        // return view('prospect.edit', compact('prospect'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Prospect $prospect)
    {
        $prospect->delete();

        flash('Data berhasil dihapus', 'success');

        return redirect()->back();
    }
}
