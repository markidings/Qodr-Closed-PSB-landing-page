<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use DateTime;
use DB;
use App\Models\MessageHistory;
use App\Models\User;


class AdminCSBookingController extends Controller
{
    public function index()
    {
        try {
            $bookings = Booking::where(['status_purchase' => null])->where('status_transaction', '!=', 'offline mandiri')->WhereNull('deleted_at')->with('city')->with('user')->get();
            $canceled = Booking::where(['status_purchase' => null])->where('status_transaction', '!=', 'offline mandiri')->WhereNotNull('deleted_at')->with('city')->with('user')->get();
            return view('booking/admincs/index', ['bookings' => $bookings, 'canceled' => $canceled]);
        } catch (\Throwable $th) {
            $bookings = Booking::where(['status_purchase' => null])->where('status_transaction', '!=', 'offline mandiri')->WhereNull('deleted_at')->with('city')->with('user')->get();
            $canceled = Booking::where(['status_purchase' => null])->where('status_transaction', '!=', 'offline mandiri')->WhereNotNull('deleted_at')->with('city')->with('user')->get();
            return view('booking/admincs/index', ['bookings' => $bookings, 'canceled' => $canceled]);
        }
    }

    public function load($month, $year)
    {
        $data = Booking::where(['status_purchase' => null])->where('status_transaction', '!=', 'offline mandiri')->WhereNull('deleted_at')->whereMonth('created_at', $month)->whereYear('created_at', $year)->with('city')->with('user')->with('packet')->get();
        return response()->json($data);
    }

    public function loadweek($week, $year)
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

        $data = Booking::where(['status_purchase' => null])->where('status_transaction', '!=', 'offline mandiri')->whereBetween('created_at', [$dates[1], $dates[2]])->with('city')->with('user')->with('packet')->get();
        return response()->json($data);
    }

    public function show()
    {
        $bookings = Booking::Status0()->get();
        return view('booking/admincs/index', ['bookings' => $bookings]);
    }

    public function edit(Request $request)
    {
        $data['partners'] = DB::table('users')->join('meta_partners', 'users.id', '=', 'meta_partners.user_id')->where('city_id', $request->city)->get();

        return response()->json($data);
    }

    public function update(Request $request)
    {
        $data = [
            'user_id' => $request->partner_id,
        ];

        $send = Booking::where('id', $request->booking_id)->update($data);
        $nota = Booking::where('id', $request->booking_id)->get();
        $template = "Silahkan klik link di bawah ini untuk melengkapi data pemesanan
https://cis.akikahkita.com/fullformbooking/" . $nota[0]->no_nota;

        if (substr(trim($nota[0]->no_whatsapp), 0, 1) == '0') {
            $nota[0]->no_whatsapp = '+62' . substr($nota[0]->no_whatsapp, 1, strlen($nota[0]->no_whatsapp));
        }

        //Get attribute value of partner for $data2[]
        $partner = User::where('id', $request->partner_id)->first();
        $partnerMessage = "Assalamualaikum $partner->name, selamat kamu telah mendapatkan leads baru atas nama: " . $nota[0]->name . ". Silahkan cek di list pemesanan tertunda ya, terimakasih.";

        $data = [
            "phone_number" => $nota[0]->no_whatsapp,
            "key" => 'e77438221c95ede5194ae2bcf724732a6221cc3d3f1f5e8a',
            "message" => $template
        ];

        $data2 = [
            "phone_number" => $partner->no_whatsapp,
            "key" => 'e77438221c95ede5194ae2bcf724732a6221cc3d3f1f5e8a',
            "message" => $partnerMessage
        ];

        //Send notif to partner choosed
        $this->send_wa($data2);
        //Send notif to customer
        $this->send_wa($data);

        MessageHistory::create([
            'type' => 'After Checkout',
            'message' => $template,
            'phone_number' => $nota[0]->no_whatsapp
        ]);


        flash('Data berhasil diperbaharui.', 'success');
        return redirect()->route('admin-cs-bookings.index');
    }

    public function destroy($id)
    {
        Booking::destroy(['id' => $id]);

        flash('Data berhasil dihapus.', 'success');
        return redirect()->route('admin-cs-bookings.index');
    }

    public function send_wa($data)
    {
        $key = 'e77438221c95ede5194ae2bcf724732a6221cc3d3f1f5e8a';
        $url = 'http://116.203.92.59/api/send_message';
        $data = array(
            "phone_no" => $data['phone_number'],
            "key"        => $key,
            "message"    => $data['message']
        );
        $data_string = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $res = curl_exec($ch);
        curl_close($ch);
    }
}
