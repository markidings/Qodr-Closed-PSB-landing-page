<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\User;
use App\Models\Brochure;
use App\Models\City;
use Auth;

use App\Http\Requests\Brochure\BrochureStore;
use App\Http\Requests\Brochure\BrochureUpdate;
use File;
use App\Models\Snack;
use Illuminate\Support\Facades\Storage;


class BrochureController extends Controller
{
    public function __construct()
    {
        // authorize role
        $adminRole = Role::ADMIN_SYSTEM; 
        $this->middleware("role:{$adminRole}");
    }

    public function index()
    {
        $brochures = Brochure::with('city')->get();
        $snacks = Snack::where('id', 2)->first();
        
        return view('brochure/index', ['brochures' => $brochures, 'snack' => $snacks]);
    }

    public function create()
    { 
        $userId = Auth::id();
        $users = User::where('role', Role::PARTNER)->where('id', $userId)->first();
        $cities = City::all();

        return view('brochure.create', compact('users', 'cities'));
    }

    public function store(BrochureStore $request)
    {
        $validatedData = $request->validated();
        
        if ($request->hasFile('brochure_image')) {
            $photoPath = $validatedData['brochure_image']->store('public/images/brochure_image');
            $validatedData['brochure_image'] = $photoPath;
        }
        $unique = Brochure::where('city_id', $request->city_id)->get();


        if (count($unique) < 1) { 
            Brochure::create($validatedData);
            flash('Data berhasil ditambahkan.', 'success');
        } else {
            flash('Regional tersebut sudah tersedia brosurnya.', 'error');
        }


        return redirect()->route('brochures.index');
    }

    public function edit(Brochure $brochure)
    {
        $users = User::where('role', Role::PARTNER)->get();
        $cities = City::all();
        

        return view('brochure.edit', compact('users', 'brochure', 'cities'));
    }

    public function update(BrochureUpdate $request)
    {
        $validatedData = $request->validated(); 

        $b = Brochure::find($request->id);
        $b->user_id = $request->user_id;
        // if ($validatedData['brochure_image']) {
        //     File::delete('storage/images/brochure_image/' . $request->old);
        //     $file = $validatedData['brochure_image'];
        //     $name_file = time() . "_asd" . $file->getClientOriginalName();
        //     $to_upload = 'storage/images/brochure_image'; // upload path
        //     $file->move($to_upload, $name_file);
        //     $validatedData['brochure_image'] = $name_file;
        // }
        // save photo
        if ($request->hasFile('brochure_image')) {
            $photoPath = $validatedData['brochure_image']->store('public/images/brochure_image');
            $validatedData['brochure_image'] = $photoPath;

            // Delete Image
            Storage::delete($request->old);
        }

        // $snack->update($updatedSnack);
        // $b->city_id = $request->city_id;
        // $b->save();

        Brochure::where('id', $request->id)->update($validatedData);
        

        flash('Data berhasil diperbarui.', 'success');

        return redirect()->route('brochures.index');
    }

    public function destroy($id)
    {
        $i = Brochure::where('id', $id)->first();
        File::delete('brochure_image/' . $i->brochure_image);

        Brochure::destroy(['id' => $id]);

        flash('Data berhasil dihapus.', 'success');
        return redirect()->route('brochures.index');
    }
}
