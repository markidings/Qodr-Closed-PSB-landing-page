<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Reseller;

use App\Http\Requests\Reseller\ResellerStore;
use App\Http\Requests\Reseller\ResellerUpdate;
use File;
use Session;


class FormResellerController extends Controller
{
    public function index() 
    {
        return view('reseller/form/register');
    }

    public function create()
    {

        
    }

    public function store(ResellerStore $request)
    {
        $Reseller = $request->validated();

        Reseller::Create($Reseller);
        
        flash('Data berhasil ditambahkan.', 'success');

        return redirect()->route('formreseller.index');
    }

    public function edit()
    {
    }

    public function update()
    {
    }

    public function destroy($id)
    {
    }
}
