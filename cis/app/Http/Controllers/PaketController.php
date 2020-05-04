<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Paket;
use App\Models\Role;

class PaketController extends Controller
{
    public function __construct()
    {
        // authorize role
        $partnerRole = Role::PARTNER;
        $this->middleware("role:{$partnerRole}");
    }

    public function index()
    {
        return view('paket.index');
    }

    public function all()
    {
        if (Auth::user()->role === 'partner') {
            return response()->json(Paket::where(['city_id' => Auth::user()->city_id])->paginate(10));
        } else {
            return response()->json(Paket::all()->paginate(10));
        }
    }


    public function store(Request $request)
    {
        $data = $this->validateAttributes();
        $data['kelebihan'] = 'sehat';
        $data['mitra_id'] = Auth::id();
        $data['user_id'] = Auth::id();
        $paket = Paket::create($data);
        return response()->json($paket);
    }

    public function show(Request $request)
    {
        $data['paket'] = Paket::where(['id' => $request->id])->first();
        return response()->json($data);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        Paket::where(['user_id' => Auth::id(), 'id' => $id])->update($this->validateAttributes());  
        return response()->json(Paket::where(['user_id' => Auth::id(), 'id' => $id])->update($this->validateAttributes()));
    }

    public function destroy(Request $request)
    {

        return response()->json(Paket::where('id', $request->id)->where('user_id', Auth::id())->delete());
    }

    public function search($param)
    {
        return response()->json(Paket::with('user','city')->where('nama', 'like', "%$param%")->where('city_id', Auth::user()->city_id)
                                    ->orWhere('menu', 'like', "%$param%")->where('city_id', Auth::user()->city_id)
                                    ->orWhere('harga', 'like', "%$param%")->where('city_id', Auth::user()->city_id)
                                    ->orderBy('id', 'DESC')->paginate(10));
    }

    protected function validateAttributes()
    {
        $data = [
            'nama' => ['required', 'min:3', 'max: 255'],
            'menu' => ['required'],
            'porsi' => ['required'],
            'keterangan' => ['required'],
            'kategori' => ['required'],
            'jk' => ['required'],
            'harga' => ['required']
        ];
        return request()->validate($data);
    }
}
