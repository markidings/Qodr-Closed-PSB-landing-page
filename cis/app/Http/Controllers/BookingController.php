<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\City;
use App\Models\Snack;
use App\Models\Paket;
use App\Models\ShippingCostPartner;
use App\Models\Promo;
use App\Models\User;
use App\Models\Brochure;
use App\Models\MessageHistory;
use App\Models\Broadcast;
use App\Models\Prospect;

use DB;


use App\Http\Requests\Booking\BookingStore;
use App\Http\Requests\Booking\BookingUpdate;
use App\Models\ProfitMitra;
use App\Services\WoowaService;

class BookingController extends Controller
{
    protected $woowaService;

    public function __construct()
    {
        $this->woowaService = new WoowaService();
    }

    public function index($id)
    {
        $city = City::where('id', $id)->get();
        $cities = DB::table('cities')->join('pakets', 'cities.id', '=', 'pakets.city_id')->get();
        $brochure = Brochure::where('city_id', $id)->get();
        $pakets = Paket::where('city_id', $id)->get();
        return view('booking.form-simple', ['city' => $city, 'brochures' => $brochure, 'pakets' => $pakets, 'cities' => $cities]);
    }

    public function success()
    {
        return view('booking.success');
    }

    public function create()
    {
    }

    public function store(BookingStore $request)
    {
        $status = 0;
        $no = time();
        $type_payment = 'online';
        $newTemplate = $request->validated();
        $newTemplate['status'] = $status;
        $newTemplate['no_nota'] = $no;
        $newTemplate['status_transaction'] = $request->status_transaction;
        $newTemplate['type_payment'] = $type_payment;
        $phoneNumber = $newTemplate['no_whatsapp'];
        $checkingProspect = Prospect::where('phone_number', 'LIKE', "%$phoneNumber%")->get();
        if (count($checkingProspect) > 0) {
            Prospect::where('phone_number', 'LIKE', "%$phoneNumber%")->update(['status' => 'success']);
        }

        $booking = Booking::create($newTemplate);

        // *** send wa with woowa service here
        $this->woowaService->sendFullFormBookingLink($booking);

        return redirect('/successbooking');
    }

    public function edit($id)
    {
        $cities = City::orderBy('name', 'ASC')->get();
        $bookings = Booking::where('no_nota', $id)->with('packet')->firstOrFail();
        $profitMitra = ProfitMitra::where('paket_id', $bookings->packet_id)->first();
        $snacks = Snack::where('user_id', $bookings->user_id)->get();
        $shippings = ShippingCostPartner::where('partner_id', $bookings->user_id)->first();
        $promos = Promo::where('user_id', $bookings->user_id)->get();
        $partner = User::where('id', $bookings->user_id)->firstOrFail();
        return view('booking.form', ['profitMitra' => $profitMitra, 'cities' => $cities, 'bookings' => $bookings, 'snacks' => $snacks, 'shippings' => $shippings, 'promos' => $promos, 'partner' => $partner]);
    }

    public function update(BookingUpdate $request, $id)
    {
        $bookings = Booking::where('no_nota', $id)->with('packet','user')->first();
        $shippings = ShippingCostPartner::where('partner_id', $bookings->user_id)->first();
        
        $status = 1;

        $fullsnack = 0;
        if(!empty($request->snack_id)){ //Setting Snack
            $snackk = explode(',',$request->snack_id);
            foreach ($snackk as $snackid) {
                $snackku = Snack::where('user_id', $bookings->user_id)->where('id',$snackid)->first();
                $fullsnack += $snackku->price;
            }
        }

        $shipping = 0;
        if(!empty($shippings)){
            if ($bookings->user->city_id == $request->city_id) { //Setting Shipping
                $shipping = $shippings->in_city_cost;
            } else {
                $shipping = $shippings->out_city_cost;
            }
        }

        if($request->jk == 'male'){ //Setting Price Goat
            $goat = $bookings->packet->harga;
        }elseif($request->jk == 'female'){
            $goat = $bookings->packet->price;
        }

        $totalProduct = $goat * $request->total_booking;

        $plus = substr($request->total_purchase,-3);

        $total_purchase = $shipping + $totalProduct + $fullsnack;


        if(!empty($request->promo_id)){ //Setting Discount
            $mypromo = Promo::where('id', $request->promo_id)->first();
            if($request->typediscount == 0){
                $total_purchase = $total_purchase - $mypromo->discount_amount;
            }else{
                $total_purchase = $total_purchase - ($total_purchase * $mypromo->discount_amount / 100);
            }
        }

        $total_purchase += $plus; 

        $validatedData = $request->validated(); 
        $validatedData['snack_id'] = $request->snack_id;
        $validatedData['shipping_charge'] = $request->shipping_charge;
        $validatedData['total_purchase'] = $total_purchase;
        $validatedData['status'] = $status;
        $validatedData['promo_id'] = $request->promo_id;

        $booking = Booking::where('no_nota', $id)->update($validatedData);
        
        // *** send wa with woowa service here
        $newbooking = $bookings->refresh();
        
        $this->woowaService->sendPaymentConfirm($newbooking);

        return redirect('/successbooking');
    }

    public function destroy($id)
    {
    }

    public function loadData($title)
    {
        $promo = Promo::where('code', $title)->first();
        if(!empty($promo)){
            if( date("Y-m-d", strtotime($promo->start_date)) <= date("Y-m-d") && date("Y-m-d", strtotime($promo->end_date)) >= date("Y-m-d")){
                $data = $promo;
            } else {
                $data = '-';
            }
        }else{
            $data = '-';
        }
        return response()->json($data);
    }

    /* WhatsApp script sender */
    public function send_to_api($dt)
    {
        $data = array(
            "phone_no" => '+62' . $dt['phone_number'],
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
