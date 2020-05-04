<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;

class PosterController extends Controller
{
    public function greeting($nota)
    {
        $booking = Booking::where('no_nota',$nota)->firstOrFail();
        return view('poster.greeting',['booking' => $booking]);
    }
    public function cut($nota)
    {
        $booking = Booking::where('no_nota',$nota)->firstOrFail();
        return view('poster.cut', ['booking' => $booking]);
    }
    public function delivery($nota)
    {
        $booking = Booking::where('no_nota',$nota)->with('user', 'snack')->firstOrFail();
        $partner = User::with('meta', 'city')->find($booking->user_id);
        return view('poster.delivery',['booking' => $booking, 'partner' => $partner]);
    }
}
