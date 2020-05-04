<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\MessageTemplate;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;



class AdminBookingDpController extends Controller
{
    public function index()
    {
        $messageTemplates = MessageTemplate::where('type', 'report')->get();

        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $bookings = Booking::where('status_purchase', 'dp')->Status1()->WhereNull('deleted_at')->where('status_transaction', '<>', 'offline mandiri')->with('packet')->orderBy('id', 'DESC')->get();
            $canceled = Booking::where('status_purchase', 'dp')->Status1()->WhereNotNull('deleted_at')->where('status_transaction', '<>', 'offline mandiri')->with('packet')->orderBy('id', 'DESC')->get();
        } elseif ($userRole == 'partner') {
            $bookings = Booking::where('status_purchase', 'dp')->Status1()->Mitra()->WhereNull('deleted_at')->with('packet')->orderBy('id', 'DESC')->get();
            $canceled = Booking::where('status_purchase', 'dp')->Status1()->Mitra()->WhereNotNull('deleted_at')->with('packet')->orderBy('id', 'DESC')->get();
        }
        
        return view('booking/dp', ['bookings' => $bookings, 'messages' => $messageTemplates, 'canceled' => $canceled]);
    }

    public function indexCompleted()
    {

        $messageTemplates = MessageTemplate::where('type', 'report')->get();

        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $bookings = Booking::where('status_purchase', 'full')->Status1()->WhereNull('deleted_at')->where('status_transaction', '<>', 'offline mandiri')->with('packet')->orderBy('id', 'DESC')->get();
            $canceled = Booking::where('status_purchase', 'full')->Status1()->WhereNotNull('deleted_at')->where('status_transaction', '<>', 'offline mandiri')->with('packet')->orderBy('id', 'DESC')->get();
        } elseif ($userRole == 'partner') {
            $bookings = Booking::where('status_purchase', 'full')->Status1()->Mitra()->WhereNull('deleted_at')->with('packet')->orderBy('id', 'DESC')->get();
            $canceled = Booking::where('status_purchase', 'full')->Status1()->Mitra()->WhereNotNull('deleted_at')->with('packet')->orderBy('id', 'DESC')->get();
        }

        return view('booking/completed', ['bookings' => $bookings, 'messages' => $messageTemplates, 'canceled' => $canceled]);
    }

    public function loadpaidoff($week, $year)
    {
        function getStartAndEndDateWeekpaidoff($week, $year)
        {
            $dateTime = new DateTime();
            $dateTime->setISODate($year, $week);
            $result[1] = $dateTime->format('Y-m-d') . ' 00:00:00';
            $dateTime->modify('+6 days');
            $result[2] = $dateTime->format('Y-m-d') . ' 00:00:00';
            return $result;
        }
        $dates = getStartAndEndDateWeekpaidoff($week, $year);

        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $data = Booking::where('status_purchase', 'full')->Status1()->WhereNull('deleted_at')->where('status_transaction', '<>', 'offline mandiri')->whereBetween('created_at', [$dates[1], $dates[2]])->with('user')->with('packet')->get();
        } elseif ($userRole == 'partner') {
            $data = Booking::where('status_purchase', 'full')->Status1()->Mitra()->WhereNull('deleted_at')->whereBetween('created_at', [$dates[1], $dates[2]])->with('user')->with('packet')->get();
        }

        return response()->json($data);
    }

    public function loadmonthpaidoff($month, $year)
    {
        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $data = Booking::where('status_purchase', 'full')->Status1()->WhereNull('deleted_at')->where('status_transaction', '<>', 'offline mandiri')->whereMonth('created_at', $month)->whereYear('created_at', $year)->with('user')->with('packet')->get();
        } elseif ($userRole == 'partner') {
            $data = Booking::where('status_purchase', 'full')->Status1()->Mitra()->WhereNull('deleted_at')->whereMonth('created_at', $month)->whereYear('created_at', $year)->with('user')->with('packet')->get();
        }

        return response()->json($data);
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

        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $data = Booking::where('status_purchase', 'dp')->Status1()->WhereNull('deleted_at')->where('status_transaction', '<>', 'offline mandiri')->whereBetween('created_at', [$dates[1], $dates[2]])->with('user')->with('packet')->get();
        } elseif ($userRole == 'partner') {
            $data = Booking::where('status_purchase', 'dp')->Status1()->Mitra()->WhereNull('deleted_at')->whereBetween('created_at', [$dates[1], $dates[2]])->with('user')->with('packet')->get();
        }

        return response()->json($data);
    }

    public function loadmonth($month, $year)
    {
        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $data = Booking::where('status_purchase', 'dp')->Status1()->WhereNull('deleted_at')->where('status_transaction', '<>', 'offline mandiri')->whereMonth('created_at', $month)->whereYear('created_at', $year)->with('user')->with('packet')->get();
        } elseif ($userRole == 'partner') {
            $data = Booking::where('status_purchase', 'dp')->Status1()->Mitra()->WhereNull('deleted_at')->whereMonth('created_at', $month)->whereYear('created_at', $year)->with('user')->with('packet')->get();
        }

        return response()->json($data);
    }

    public function show()
    {
        $bookings = Booking::Status1()->get();
        return view('booking/index', ['bookings' => $bookings]);
    }

    public function update(Request $request)
    {
        Booking::where('id', $request->id)->update(['status_processing' => $request->status_processing]);

        flash('Data berhasil diproses', 'success');

        /* Report client */
        if ($request->message != null) {
            $user = Booking::where('id', $request->id)->get();
            $msg = $request->message;

            $msg = str_replace("%nama%", $user[0]->name, $msg);
            $msg = str_replace("%no_wa%", $user[0]->no_whatsapp, $msg);

            //cari spin text
            $text_split_arr = explode("{", $msg);
            foreach ($text_split_arr as $k2 => $v2) {
                if ($k2 == 0) {
                    continue;
                }
                $text_split_arr1 = explode("}", $v2);
                if (is_array($text_split_arr1) and trim($v2) != '') {
                    $pilih_spin_arr = explode("|", $text_split_arr1[0]);
                    $spin_terpilih = $pilih_spin_arr[rand(0, count($pilih_spin_arr) - 1)];

                    $text_spin[$k2] = $spin_terpilih;
                }
            }

            //baca string ganti spin keyword jadi variable spin0 spin1
            $text_temp = str_split($msg);
            $spin_ke = 1;
            $text1 = $msg;
            foreach ($text_temp as $k3 => $huruf) {
                if ($huruf == '{') {
                    $index_awal = $k3;
                }
                if ($huruf == '}') {
                    $index_akhir = $k3;
                    $spintext = substr($msg, $index_awal, ($index_akhir - $index_awal + 1));
                    $text1 = str_replace("$spintext", "{spin$spin_ke}", $text1);
                    $spin_ke++;
                }
            }
            //ganti {spin1} dengan keyword terpilih
            $final_text = $text1;
            if (isset($text_spin)) {
                foreach ($text_spin as $k4 => $v4) {
                    $final_text = str_replace("{spin$k4}", $v4, $final_text);
                }
            }

            /* Phone Number Validation */
            if (substr(trim($user[0]->no_whatsapp), 0, 2) == '00') {
                $user[0]->no_whatsapp = '+' . substr($user[0]->no_whatsapp, 2, strlen($user[0]->no_whatsapp));
            }
            if (substr(trim($user[0]->no_whatsapp), 0, 1) == '0') {
                $user[0]->no_whatsapp = '+963' . substr($user[0]->no_whatsapp, 1, strlen($user[0]->no_whatsapp));
            }

            /* Data ready for insert db */
            $data = [
                'message' => $final_text,
                'phone_number' => $user[0]->no_whatsapp,
                'type' => 'broadcast'
            ];

            // Upload image
            if ($request->image != null) {
                $image = $request->image;

                $destinationPath = 'storage/images/reports'; // upload path
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);

                $data['image'] = $profileImage;
                $this->send_to_api_image($data);
            } else {
                $this->send_to_api($data);
            }
        }
        return redirect()->route('report-partner.index');
    }

    public function updateCompleted(Request $request)
    {
        Booking::where('id', $request->id)->update(['status_processing' => $request->status_processing]);

        flash('Data berhasil diproses', 'success');

        /* Report client */
        if ($request->message != null) {
            $user = Booking::where('id', $request->id)->get();
            $msg = $request->message;

            $msg = str_replace("%nama%", $user[0]->name, $msg);
            $msg = str_replace("%no_wa%", $user[0]->no_whatsapp, $msg);

            //cari spin text
            $text_split_arr = explode("{", $msg);
            foreach ($text_split_arr as $k2 => $v2) {
                if ($k2 == 0) {
                    continue;
                }
                $text_split_arr1 = explode("}", $v2);
                if (is_array($text_split_arr1) and trim($v2) != '') {
                    $pilih_spin_arr = explode("|", $text_split_arr1[0]);
                    $spin_terpilih = $pilih_spin_arr[rand(0, count($pilih_spin_arr) - 1)];

                    $text_spin[$k2] = $spin_terpilih;
                }
            }

            //baca string ganti spin keyword jadi variable spin0 spin1
            $text_temp = str_split($msg);
            $spin_ke = 1;
            $text1 = $msg;
            foreach ($text_temp as $k3 => $huruf) {
                if ($huruf == '{') {
                    $index_awal = $k3;
                }
                if ($huruf == '}') {
                    $index_akhir = $k3;
                    $spintext = substr($msg, $index_awal, ($index_akhir - $index_awal + 1));
                    $text1 = str_replace("$spintext", "{spin$spin_ke}", $text1);
                    $spin_ke++;
                }
            }
            //ganti {spin1} dengan keyword terpilih
            $final_text = $text1;
            if (isset($text_spin)) {
                foreach ($text_spin as $k4 => $v4) {
                    $final_text = str_replace("{spin$k4}", $v4, $final_text);
                }
            }

            /* Phone Number Validation */
            if (substr(trim($user[0]->no_whatsapp), 0, 2) == '00') {
                $user[0]->no_whatsapp = '+' . substr($user[0]->no_whatsapp, 2, strlen($user[0]->no_whatsapp));
            }
            if (substr(trim($user[0]->no_whatsapp), 0, 1) == '0') {
                $user[0]->no_whatsapp = '+963' . substr($user[0]->no_whatsapp, 1, strlen($user[0]->no_whatsapp));
            }

            /* Data ready for insert db */
            $data = [
                'message' => $final_text,
                'phone_number' => $user[0]->no_whatsapp,
                'type' => 'broadcast'
            ];

            // Upload image
            if ($request->image != null) {
                $image = $request->image;

                $destinationPath = 'storage/images/reports'; // upload path
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);

                $data['image'] = $profileImage;
                $this->send_to_api_image($data);
            } else {
                $this->send_to_api($data);
            }
        }
        return redirect()->route('report-partner.completed');
    }

    public function destroy($id)
    {
        Booking::destroy(['id' => $id]);

        flash('Data berhasil dihapus.', 'success');
        return redirect()->route('report-partner.index');
    }

    public function cancel(Request $request)
    {
        Booking::where('id', $request->modalListId)->update(['deleted_at' => Carbon::now()]);
        flash('Data berhasil dibatalkan', 'success');
        // return redirect('/dashboard/admin-cs-bookings-dp');
        return redirect()->back();
    }

    /* WhatsApp script sender with image */
    public function send_to_api_image($dt)
    {
        $image = $dt['image'];
        $key = 'e77438221c95ede5194ae2bcf724732a6221cc3d3f1f5e8a';
        $url = 'http://116.203.92.59/api/async_send_image_url';
        $img_url = "http://localhost:8000/storage/images/reports/$image";
        $data = array(
            "phone_no" => $dt['phone_number'],
            "key"        => $key,
            "url"        => $img_url,
            "message"    => $dt['message']
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
        echo $res = curl_exec($ch);
        curl_close($ch);
    }

    /* WhatsApp script sender */
    public function send_to_api($dt)
    {
        $data = array(
            "phone_no" => $dt['phone_number'],
            // "phone_no" => '+628975835238',
            "key" => 'e77438221c95ede5194ae2bcf724732a6221cc3d3f1f5e8a',
            "message" => $dt['message']
        );
        // echo "<pre>".print_r($data,1)."</pre>";die();
        $data_string = json_encode($data);
        $url = 'http://116.203.92.59/api/async_send_message';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
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

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $response;
    }
}
