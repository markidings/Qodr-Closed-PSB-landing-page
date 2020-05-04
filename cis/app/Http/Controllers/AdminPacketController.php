<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

use App\Models\AdminPacket;
use App\Models\Role;
use App\Models\City;
use App\Models\User;

class AdminPacketController extends Controller
{

    public function __construct()
    {
        // authorize role
        $adminSystemRole = Role::ADMIN_SYSTEM;
        $adminCSRole = Role::ADMIN_CS;
        if (Auth::check()) {
            if (Auth::user()->role == $adminSystemRole || Auth::user()->role == $adminCSRole) {
                $this->middleware("role:{$adminSystemRole}" || "role:{$adminCSRole}");
            }
        }
    }

    public function index()
    {
        return view('adminPacket.index');
    }

    public function all()
    {
        return response()->json(AdminPacket::with('city')->orderBy('id', 'DESC')->paginate(10));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $data = $this->validateAttributes();
        $image = $data['gambar'];
        if(!isset($request->harga) && !isset($request->price)){
            $data = $request->validate([
                'harga' => 'required',
                'price' => 'required' 
            ]);
        }else{
            $data['harga'] = $request->harga;
            $data['price'] = $request->price;
        }
        // Upload image
        $destinationPath = 'storage/images/packets'; // upload path
        $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
        $image->move($destinationPath, $profileImage); 

        $data['gambar'] = $profileImage;
        $data['kelebihan'] = 'sehat';
        $data['city_id'] = $data['city_id'];
        $paket = AdminPacket::create($data);
        return response()->json($paket);
    }

    public function show(Request $request)
    {
        $data['partner'] = City::all();
        $data['paket'] = AdminPacket::with('city')->where(['id' => $request->id])->first();
        return response()->json($data);
    }

    public function showPartner(Request $request)
    {
        $data['partner'] = City::all();
        return response()->json($data);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $data = $this->validateAttributes();

        if(!isset($request->harga) && !isset($request->price)){
            $data = $request->validate([
                'harga' => 'required',
                'price' => 'required' 
            ]);
        }else{
            $data['harga'] = $request->harga;
            $data['price'] = $request->price;
        }

        if (isset($data['gambar'])) {

            $image = $data['gambar'];

            $oldImage = AdminPacket::where('id', $id)->get();
            $oldImage = $oldImage[0]->gambar;

            // Delete Image
            Storage::delete("public/images/packets/$oldImage");

            // Upload new Image
            $destinationPath = 'storage/images/packets'; // upload path
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);

            // Image name
            $data['gambar'] = $profileImage;
        }
        $paket = AdminPacket::where(['id' => $id])->update($data);
        // response()->json(['success' => 'success'], 200);
        return response()->json($paket);
    }

    public function destroy(Request $request)
    {
        Storage::delete("public/images/packets/$request->img");
        return response()->json(AdminPacket::where('id', $request->id)->delete());
    }

    public function search($param)
    {
        $city = City::where([['name', 'like', "%$param%"]])->first();
        $cities = (!empty($city)) ? $city->id : '-' ;
        return response()->json(AdminPacket::with('user','city')->where('nama', 'like', "%$param%")->orWhere('menu', 'like', "%$param%")->orWhere('harga', 'like', "%$param%")->orWhere('price', 'like', "%$param%")->orWhere('city_id', 'like', "%$cities%")->orderBy('id', 'DESC')->paginate(10));
    }

    protected function validateAttributes()
    {
        $data = [
            'city_id' => ['required'],
            'nama' => ['required', 'min:3', 'max: 255'],
            'menu' => ['nullable'],
            'porsi' => ['nullable'],
            'keterangan' => ['required'],
            'kategori' => ['required'],
            'gambar' => ['nullable','file', 'image', 'mimes:jpeg,png,jpg', 'max:1024']
        ];

        return request()->validate($data);
    }
}
