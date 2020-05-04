<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MessageTemplate;
use App\Models\User;
use App\Models\Booking;
use App\Models\Broadcast;
use App\Models\Reseller;

class BroadcastController extends Controller
{
    public function index()
    {
        $messageTemplates = MessageTemplate::where('type', 'broadcast')->get();
        $users = User::all();
        $customers = Booking::all();
        return view('broadcast.index', compact('messageTemplates', 'customers'));
    }

    // Send One Message
    public function store(Request $request)
    {
        $user = Booking::where('id', $request->user_id)->get();
        $msg = $request->message;

        $validatedData = $request->validate([
            'message' => 'required',
            'phone_number' => 'required'
        ]);

        $validatedData['type'] = 'broadcast';


        $msg = str_replace("%paket%", $user[0]->packet->nama, $msg);
        $msg = str_replace("%pemesan%", $user[0]->name, $msg);
        $msg = str_replace("%anak%", $user[0]->name_aqiqah, $msg);
        $msg = str_replace("%ayah%", $user[0]->name_father, $msg);
        $msg = str_replace("%ibu%", $user[0]->name_mother, $msg);
        $msg = str_replace("%status_proses%", $user[0]->status_processing, $msg);


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
            $user[0]->no_whatsapp = '+62' . substr($user[0]->no_whatsapp, 1, strlen($user[0]->no_whatsapp));
        }

        /* Data ready for insert db */
        $data = [
            'message' => $final_text,
            'phone_number' => $user[0]->no_whatsapp,
            'type' => 'broadcast'
        ];

        $this->send_to_api($data);

        return response()->json(Broadcast::create($data));
    }

    /* Send Many Message */
    public function storeAll(Request $request)
    {
        $listUsers = explode(",", $request->mitra_id);

        if (ob_get_level() == 0) ob_start();
        foreach ($listUsers as $listUser) {
            $user = Booking::where('id', $listUser)->get();
            $msg = $request->message;


            $validatedData = $request->validate([
                'message' => 'required',
            ]);

            $validatedData['type'] = 'broadcast';

            $msg = str_replace("%paket%", $user[0]->packet->nama, $msg);
            $msg = str_replace("%pemesan%", $user[0]->name, $msg);
            $msg = str_replace("%anak%", $user[0]->name_aqiqah, $msg);
            $msg = str_replace("%ayah%", $user[0]->name_father, $msg);
            $msg = str_replace("%ibu%", $user[0]->name_mother, $msg);
            $msg = str_replace("%status_proses%", $user[0]->status_processing, $msg);

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
                $user[0]->no_whatsapp = '+62' . substr($user[0]->no_whatsapp, 1, strlen($user[0]->no_whatsapp));
            }

            /* Data ready for insert db */
            $data = [
                'message' => $final_text,
                'phone_number' => $user[0]->no_whatsapp,
                'type' => 'broadcast'
            ];

            /* Math Random Time */
            $this->send_to_api($data);
            $okray = Broadcast::create($data);
            echo date('h:i:s') . "<br />";

            $number = rand(1, 10);
            ob_flush();
            flush();
            sleep($number);
        }
        ob_end_flush();
        return response()->json($okray);
    }

    /* Broadcast for all user role */
    public function storeRole(Request $request)
    {
        if ($request->mitra_id === 'reseller') {
            $listUsers = Reseller::all();
        } else {
            $listUsers = User::where('role', $request->mitra_id)->get();
        }

        if (ob_get_level() == 0) ob_start();
        foreach ($listUsers as $listUser) {
            $user = $listUser;
            $msg = $request->message;


            $validatedData = $request->validate([
                'message' => 'required',
            ]);

            $validatedData['type'] = 'broadcast';

            $msg = str_replace("%paket%", ' ', $msg); 
            $msg = str_replace("%pemesan%", ' ', $msg);
            $msg = str_replace("%anak%", ' ', $msg);
            $msg = str_replace("%ayah%", ' ', $msg);
            $msg = str_replace("%ibu%", ' ', $msg);
            $msg = str_replace("%status_proses%", ' ', $msg);

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
            if (substr(trim($user->no_whatsapp), 0, 2) == '00') {
                $user->no_whatsapp = '+' . substr($user->no_whatsapp, 2, strlen($user->no_whatsapp));
            }
            if (substr(trim($user->no_whatsapp), 0, 1) == '0') {
                $user->no_whatsapp = '+62' . substr($user->no_whatsapp, 1, strlen($user->no_whatsapp));
            }

            /* Data ready for insert db */
            $data = [
                'message' => $final_text,
                'phone_number' => $user->no_whatsapp,
                'type' => 'broadcast'
            ];
            // dd($data);

            /* Math Random Time */
            $this->send_to_api($data);
            $okray = Broadcast::create($data);
            echo date('h:i:s') . "<br />";

            $number = rand(1, 10);
            ob_flush();
            flush();
            sleep($number);
        }
        ob_end_flush();
        return response()->json($okray);
    }

    /* WhatsApp script sender */
    public function send_to_api($dt)
    {
        $data = array(
            "phone_no" => $dt['phone_number'],
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
