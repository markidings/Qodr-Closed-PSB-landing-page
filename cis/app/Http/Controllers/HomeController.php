<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use App\Models\Booking;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = count(User::Where('role','partner')->WhereNull('deleted_at')->Get());
        $customer = count(Booking::WhereNotNull('status_purchase')->WhereNull('deleted_at')->Get());
        $panding = count(Booking::whereNull('status_purchase')->where('status_transaction', '!=','offline mandiri')->WhereNull('deleted_at')->get());
        $city = count(City::Get());
        
        return view('dashboard.index',compact('city','user', 'customer', 'panding'));
    }
}
