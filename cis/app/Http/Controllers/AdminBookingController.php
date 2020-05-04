<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Role;
// use App\Models\User; 
use App\Models\Booking;
use App\Models\Paket;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;



class AdminBookingController extends Controller
{
    public function index()
    {

        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $bookings = Booking::where('status_purchase', null)->get();
        } elseif ($userRole == 'partner') {
            $bookings = Booking::where('status_purchase', '=', null)->Mitra()->with('packet')->get();
        }
        // elseif ($userRole == 'admin_cs') { 
        //     $bookings = Booking::Mitra()->Status0()->get();
        // }

        return view('booking/index', ['bookings' => $bookings]);
    }

    public function load($week, $year)
    {
        function getStartAndEndDateWeek($week, $year)
        {
            $dateTime = new DateTime();
            $dateTime->setISODate($year, $week);
            $result[1] = $dateTime->format('Y-m-d') . ' 00:00:00';
            $dateTime->modify('+6 days');
            $result[2] = $dateTime->format('Y-m-d') . ' 00:00:00';
            return $result;
        }
        $dates = getStartAndEndDateWeek($week, $year);

        $data = Booking::where('status_purchase', null)->Mitra()->whereBetween('created_at', [$dates[1], $dates[2]])->with('packet')->get();
        return response()->json($data);
    }

    public function loadmonth($month, $year)
    {
        $data = Booking::where('status_purchase', null)->Mitra()->whereMonth('created_at', $month)->whereYear('created_at', $year)->with('packet')->get();
        return response()->json($data);
    }

    public function edit()
    {
    }
}
