<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\ShippingCostPartner;
use App\Models\SettingBankAccount;
use App\Models\PurchaseConfirm;
use App\Models\Booking;
use App\Models\Broadcast;
use App\Models\Paket;
use App\Models\Snack;
use App\Models\Promo;
use App\Models\City;
use App\Models\MessageHistory;
use App\Models\Prospect;


use App\Http\Requests\Booking\PartnerBookingStore;
use App\Services\WoowaService;


class PartnerBookingController extends Controller
{

    protected $woowaService;

    public function __construct()
    {
        $this->woowaService = new WoowaService();
    }

    public function index()
    {
        $city_id = Auth::user()->city_id;
        $user_id = Auth::user()->id;

        $pakets = Paket::with("city")->get();
        $snacks = Snack::where('user_id', $user_id)->get();
        $city = City::get();
        $shippings = ShippingCostPartner::where('partner_id', $user_id)->first();

        return view('booking.partner-booking.adminform', ['user_id' => $user_id, 'shippings' => $shippings, 'city_id' => $city_id, 'pakets' => $pakets, 'snacks' => $snacks, 'city' => $city]);
    }

    public function show()
    {
        $city_id = Auth::user()->city_id;
        $user_id = Auth::user()->id;

        $pakets = Paket::with("city")->get();
        $snacks = Snack::where('user_id', $user_id)->get();
        $city = City::get();
        $shippings = ShippingCostPartner::where('partner_id', $user_id)->first();

        return view('booking.partner-booking.adminformbook', ['user_id' => $user_id, 'shippings' => $shippings, 'city_id' => $city_id, 'pakets' => $pakets, 'snacks' => $snacks, 'city' => $city]);
    }

    public function store(PartnerBookingStore $request)
    {
        $user_id = Auth::user()->id;
        $fullsnack = 0;
        if (!empty($request->snack_id)) { //Setting Snack
            $snackk = explode(',', $request->snack_id);
            foreach ($snackk as $snackid) {
                $snackku = Snack::where('user_id', $user_id)->where('id', $snackid)->first();
                $fullsnack += $snackku->price;
            }
        }

        $city_id = Auth::user()->city_id;
        $shippings = ShippingCostPartner::where('partner_id', $user_id)->first();
        $shipping = 0;
        if (!empty($shippings)) {
            if ($city_id == $request->city_id) { //Setting Shipping
                $shipping = $shippings->in_city_cost;
            } else {
                $shipping = $shippings->out_city_cost;
            }
        }

        $packet = Paket::where('city_id', $city_id)->first();
        if ($request->jk == 'male') { //Setting Price Goat
            $goat = $packet->harga;
        } elseif ($request->jk == 'female') {
            $goat = $packet->price;
        }

        $totalProduct = $goat * $request->total_booking;

        $plus = substr($request->total_purchase, -3);
        $total_purchase = $shipping + $totalProduct + $fullsnack;

        if (!empty($request->promo_id)) { //Setting Discount
            $mypromo = Promo::where('id', $request->promo_id)->first();
            if ($request->typediscount == 0) {
                $total_purchase = $total_purchase - $mypromo->discount_amount;
            } else {
                $total_purchase = $total_purchase - ($total_purchase * $mypromo->discount_amount / 100);
            }
        }

        $total_purchase += $plus;
        
        $status = 1;
        $no = time();
        $type = $request->type_purchase;
        $purchase = $total_purchase;
        $newTemplate = $request->validated();
        $newTemplate['status'] = $status;
        $newTemplate['no_nota'] = $no;
        $newTemplate['snack_id'] = $request->snack_id;
        $newTemplate['promo_id'] = $request->promo_id;
        $newTemplate['status_purchase'] = $type;
        $newTemplate['total_purchase'] = $total_purchase;
        $paket = Paket::where('id', $request->packet_id)->first();
        $booking = Booking::create($newTemplate);

        // Check and update prospect module
        $noWa = $request->no_whatsapp;
        $checkingProspect = Prospect::where('phone_number', 'LIKE', "%$noWa%")->get();
        if (count($checkingProspect) > 0) {
            Prospect::where('phone_number', 'LIKE', "%$noWa%")->update(['status' => 'success']);
        }

        if (substr(trim($noWa), 0, 1) == '0') {
            $noWa = '+62' . substr($noWa, 1, strlen($noWa));
        }

        $nominal = ($type == 'dp') ? rtrim(rtrim(sprintf('%.1f', ceil($purchase / 2)), '0'), '.') : $purchase;

        $bankAccount = SettingBankAccount::first();
        if ($booking['type_payment'] == 'offline' && $type == 'dp') {
            $nextPayment = $booking->total_purchase - $nominal;
            $uniquePrice = rand(99, 999);
            $dp = $nextPayment + $uniquePrice;
            PurchaseConfirm::create([
                'booking_id' => $booking->id,
                'no_nota' => $no,
                'nominal' => $nominal,
                'paid_off' => $dp
            ]);

            $template = "Terimakasih telah melakukan pemesanan di akikahkita.com, data pemesanan anda :
            
            Nama : *$booking->name*
            Nama Anak : *$booking->name_aqiqah*
            Paket : *$paket->nama*
            Porsi : *$paket->porsi*
            Total Biaya : *" . format_rupiah($booking->total_purchase) . "*
            Total Bayar : *" . format_rupiah($nominal) . "*
            Tanggal Pemotongan : *$booking->time_slaughter*
            
        Jangan lupa untuk membayar sisa dp anda sebesar " . format_rupiah($dp) . " melalui: 
            Nama : *$bankAccount->name*
            Bank : *$bankAccount->bank*
            Rekening : *$bankAccount->account_number*
            ";
        } elseif ($booking['type_payment'] == 'offline' && $type == 'full') {
            $nextPayment = $booking->total_purchase - $nominal;
            $uniquePrice = rand(99, 999);
            $dp = $nextPayment + $uniquePrice;
            PurchaseConfirm::create([
                'booking_id' => $booking->id,
                'no_nota' => $no,
                'nominal' => $nominal,
                'paid_off' => $dp
            ]);

            $template = "Terimakasih telah melakukan pemesanan di akikahkita.com, data pemesanan anda :

            Nama : *$booking->name*
            Nama Anak : *$booking->name_aqiqah*
            Paket : *$paket->nama*
            Porsi : *$paket->porsi*
            Total Biaya : *" . format_rupiah($booking->total_purchase) . "*
            Total Bayar : *" . format_rupiah($nominal) . "*
            Tanggal Pemotongan : *$booking->time_slaughter*
            
        Pesanan anda akan segera kami proses.
            ";
        } elseif ($booking['type_payment'] == 'offline transfer') {
            $template = "Terimakasih telah melakukan pemesanan di akikahkita.com, data pemesanan anda :
            Nama : *$booking->name* 
            Nama Anak : *$booking->name_aqiqah*
            Paket : *$paket->nama*
            Porsi : *$paket->porsi*
            Total Biaya : *" . format_rupiah($booking->total_purchase) . "*
            Tanggal Pemotongan : *$booking->time_slaughter*
            
            Agar pemesanan anda bisa segera di proses, silahkan transfer melalui :
            Nama : *$bankAccount->name*
            Bank : *$bankAccount->bank*
            Rekening : *$bankAccount->account_number*
            Total Bayar : *" . format_rupiah($nominal) . "*
            
    Silahkan kirim bukti pembayaran anda dengan membalas pesan ini, terimakasih..";
        }

        $data = [
            'phone_number' => $noWa,
            'template' => $template,
        ];

        $this->send_wa($data);

        $data = [
            'message' => $template,
            'phone_number' => $noWa,
            'type' => 'transaction'
        ];
        $history = Broadcast::create($data);

        flash('Data Berhasil Dipesan.', 'success');

        if ($request->status_transaction == 'offline lead') {
            return redirect()->route('partnerBookingForm.index');
        } elseif ($request->status_transaction == 'offline mandiri') {
            return redirect()->route('partnerBookingForm.show');
        } else {
            return redirect()->route('partnerBookingForm.index');
        }
    }

    public function loadData($title)
    {
        $promo = Promo::where('code', $title)->first();
        if (!empty($promo)) {
            if (date("Y-m-d", strtotime($promo->start_date)) <= date("Y-m-d") && date("Y-m-d", strtotime($promo->end_date)) >= date("Y-m-d")) {
                $data = $promo;
            } else {
                $data = '-';
            }
        } else {
            $data = '-';
        }
        return response()->json($data);
    }

    public function send_wa($data)
    {
        $key = 'e77438221c95ede5194ae2bcf724732a6221cc3d3f1f5e8a';
        $url = 'http://116.203.92.59/api/send_message';
        $data = array(
            "phone_no" => $data['phone_number'],
            "key"        => $key,
            "message"    => $data['template']
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
