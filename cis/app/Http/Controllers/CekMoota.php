<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\PurchaseConfirm;
use App\Models\Broadcast;
use App\Services\WoowaService;

class CekMoota extends Controller
{
    protected $woowaService;

    public function __construct()
    {
        $this->woowaService = new WoowaService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking = Booking::where('type_purchase', '!=', null)->where('status_transaction', '!=','offline mandiri')->WhereNull('deleted_at')->with('city','user')->get();
        // where(['status_purchase' => null])->
        foreach($booking as $bookings){
            if ($bookings['status_purchase'] == null && $bookings['type_purchase'] == 'full'){
                $nominal = $bookings['total_purchase'];
                $datamota = $this->moota($nominal);
                            
                $data = json_decode($datamota, true); 
                
                if(!empty($data['mutation'])){
                    $booking = Booking::find($bookings['id']);
            
                    $booking->update([
                        'status_purchase' => 'full'
                    ]);

                    $datapurchase = [
                        'booking_id' => $booking['id'],
                        'no_nota' => $booking['no_nota'],
                        'nominal' => $nominal
                    ];

                    PurchaseConfirm::create($datapurchase);

                    $data = [
                        'message' => "Terimakasih telah membayar Lunas sebesar *Rp.$nominal*, pesanan anda akan segera di proses.",
                        'phone_number' => $booking['no_whatsapp'],
                        'type' => 'transaction'
                    ];
                    $moota = $this->woowaService->sendMoota($data);
                    // echo $moota;
                }

            }elseif($bookings['type_purchase'] == 'dp'){
                if($bookings['status_purchase'] == null){
                    $nominal = $bookings['total_purchase'] / 2;
                    $datamota = $this->moota($nominal);
                    $plus = rand(99,999);
                    $dp = $nominal + $plus; 
                                
                    $data = json_decode($datamota, true); 
    
                    if(!empty($data['mutation'])){
                        $booking = Booking::find($bookings['id']);
                
                        $booking->update([
                            'status_purchase' => 'dp'
                        ]);
                            
                        $datapurchase = [
                            'booking_id' => $booking['id'],
                            'no_nota' => $booking['no_nota'],
                            'nominal' => $nominal,
                            'paid_off' => $dp
                        ];
                        
                        $cek = PurchaseConfirm::create($datapurchase);
                        
                        $data = [
                            'message' => "Terimakasih telah membayar DP sebesar *Rp.$nominal*, pesanan anda akan segera di proses. Jangan lupa untuk membayar kekurangan anda sebesar Rp.$dp.",
                            'phone_number' => $booking['no_whatsapp'],
                            'type' => 'transaction'
                        ];
                        $moota = $this->woowaService->sendMoota($data);
                        // echo $moota;
                    }
                } elseif($bookings['status_purchase'] == 'dp'){
                    $nominalpaid = PurchaseConfirm::find($bookings['id']);
                    $nominal = $nominalpaid['paid_off'];
                    // dd($nominal['paid_off']);
                    $datamota = $this->moota($nominal);
                                
                    $data = json_decode($datamota, true); 
    
                    if(!empty($data['mutation'])){
                        $booking = Booking::find($bookings['id']);
                
                        $booking->update([
                            'status_purchase' => 'full'
                        ]);
                            
                        $datapurchase = [
                            'nominal' => $nominal + $nominalpaid['nominal'],
                            'paid_off' => $nominal - $nominalpaid['nominal'],
                        ];
    
                        // PurchaseConfirm::create($datapurchase);
                        $nominalpaid->update($datapurchase);
                        $data = [
                            'message' => "Terimakasih telah membayar lunas sebesar *Rp.$nominal*, pesanan anda masih dalam proses.",
                            'phone_number' => $booking['no_whatsapp'],
                            'type' => 'transaction'
                        ];
                        $moota = $this->woowaService->sendMoota($data);
                        // echo $moota;
                    }
                }
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function moota($nominal)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://app.moota.co/api/v1/bank/pG1kady5WgM/mutation/search/'.$nominal);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'Authorization: Bearer htUQxcB2QOgl57woy2zqTJU2Q2mkxnCgrl0BBGBiyC3ZeLBAmd'
        ]);
        $response = curl_exec($curl);

        return $response;
    }
}
