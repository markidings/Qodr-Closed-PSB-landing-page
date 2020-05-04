<?php

namespace App\Http\Controllers;

use App\Models\ProfitReport;
use Illuminate\Http\Request;

use App\Models\Paket;
use App\Models\PurchaseConfirm;
use App\Models\ProfitMitra;
use App\Models\Booking;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class ProfitReportController extends Controller
{
    public function index()
    {
        $newbooking = Booking::Status1()->whereNotNull('status_purchase')->WhereNull('bookings.deleted_at')->with('packet')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->get();

        foreach($newbooking as $book){

            if ($book->status_transaction == 'offline mandiri') {
                $profit = 0;
            } else {

                if ($book->type_goat == 'male') {
                    $profit = $book->profit_male;
                } else {
                    $profit = $book->profit_female;
                }
            }
            
            $profitstatus = PurchaseConfirm::where('no_nota', $book['no_nota'])->first();
            if(!empty($profitstatus)){
                if($profit != 0){
                    if($book->type_payment == 'offline'){
                        $price = $profit;
                    }else{
                        $price = $book->total_purchase - $profit;
                    }
                    //Cek kondisi apakah ada pengiriman di moota dengan nominal $price 
                    $datamoota = $this->mootareport($price); 
                    $data = json_decode($datamoota, true); 

                    if(!empty($data['mutation'])){
                            //update bila ada data mutationnya
                            $profitstatus->update([ 
                                'deposit_status' => 'done'
                            ]);
                    }
                } else if ($profit == 0){
                    //update bila ada data mutationnya
                    $profitstatus->update([ 
                        'deposit_status' => 'no'
                    ]);
                }
            }
        }
        $booking = Booking::Status1()->whereNotNull('status_purchase')->WhereNull('bookings.deleted_at')->with('packet')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->where('status_transaction', 'online')->get();
        $bookingOffline = Booking::Status1()->whereNotNull('status_purchase')->WhereNull('bookings.deleted_at')->with('packet')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->where('status_transaction', '!=', 'online')->get();
        
        return view('profit-report.index', ['booking' => $booking, 'bookingOffline' => $bookingOffline]);
    }

    //index partner
    public function indexpartner()
    {
        $newbooking = Booking::Status1()->whereNotNull('status_purchase')->WhereNull('bookings.deleted_at')->Mitra()->with('packet')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->get();
        foreach($newbooking as $book){

            if ($book->status_transaction == 'offline mandiri') {
                $profit = 0;
            } else {

                if ($book->type_goat == 'male') {
                    $profit = $book->profit_male;
                } else {
                    $profit = $book->profit_female;
                }
            }
            
            $profitstatus = PurchaseConfirm::where('no_nota', $book['no_nota'])->first();
            if(!empty($profitstatus)){
                if($profit != 0){
                    if($book->type_payment == 'offline'){
                        $price = $profit;
                    }else{
                        $price = $book->total_purchase - $profit;
                    }

                    //Cek kondisi apakah ada pengiriman di moota dengan nominal $price 
                    $datamoota = $this->mootareport($price); 
                    $data = json_decode($datamoota, true); 

                    if(!empty($data['mutation'])){
                            //update bila ada data mutationnya
                            $profitstatus->update([ 
                                'deposit_status' => 'done'
                            ]);
                    }
                } else if ($profit == 0){
                    //update bila ada data mutationnya
                    $profitstatus->update([ 
                        'deposit_status' => 'no'
                    ]);
                }
            }
        }

        $booking = Booking::Status1()->whereNotNull('status_purchase')->WhereNull('bookings.deleted_at')->Mitra()->with('packet')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->where('status_transaction', 'online')->get();
        $bookingOffline = Booking::Status1()->whereNotNull('status_purchase')->WhereNull('bookings.deleted_at')->Mitra()->with('packet')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->where('status_transaction', '!=', 'online')->get();
        
        return view('profit-report.indexpartner', ['booking' => $booking, 'bookingOffline' => $bookingOffline]);
    }


    //Display sorting by month
    public function load($month, $year)
    {
        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $data['booking'] = Booking::Status1()->WhereNull('bookings.deleted_at')->whereMonth('bookings.created_at', $month)->whereYear('bookings.created_at', $year)->with('packet', 'user', 'purchase_confirm')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->where('status_transaction', '<>', 'offline mandiri')->get();
        } elseif ($userRole == 'partner') {
            $data['booking'] = Booking::Status1()->WhereNull('bookings.deleted_at')->whereMonth('bookings.created_at', $month)->whereYear('bookings.created_at', $year)->Mitra()->with('packet', 'user', 'purchase_confirm')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->get();
        }

        // $data['booking'] = Booking::Status1()->WhereNull('bookings.deleted_at')->whereMonth('created_at', $month)->whereYear('created_at', $year)->with('user', 'packet', 'purchase_confirm')->get();
        if ($data['booking'] == null || count($data['booking']) < 1) {
            $data['empty'] = 'Data tidak ditemukan';
            return response()->json($data['empty']);
        } else {
            $data['profit'] = ProfitMitra::get();
            return response()->json($data);
        }
    }
    //sorting display by week
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

        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $data['booking'] = Booking::Status1()->WhereNull('bookings.deleted_at')->whereBetween('bookings.created_at', [$dates[1], $dates[2]])->with('packet', 'user', 'purchase_confirm')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->where('status_transaction', '<>', 'offline mandiri')->get();
        } elseif ($userRole == 'partner') {
            $data['booking'] = Booking::Status1()->WhereNull('bookings.deleted_at')->whereBetween('bookings.created_at', [$dates[1], $dates[2]])->Mitra()->with('packet', 'user', 'purchase_confirm')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->get();
        }

        // $data['booking'] = Booking::Status1()->WhereNull('bookings.deleted_at')->whereBetween('created_at', [$dates[1], $dates[2]])->with('user', 'packet', 'purchase_confirm')->get();
        // dd($data['booking']);
        if ($data['booking'] == null || count($data['booking']) < 1) {
            $data['empty'] = 'Data tidak ditemukan';
            return response()->json($data['empty']);
        } else {
            $data['profit'] = ProfitMitra::get();
            return response()->json($data);
        }
    }
    //display sorting by day
    public function loadday($day)
    {
        $userRole = Auth::user()->role;
        if ($userRole == 'admin_system') {
            $data['booking'] = Booking::Status1()->WhereNull('bookings.deleted_at')->whereDate('bookings.created_at', $day)->with('packet', 'user', 'purchase_confirm')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->where('status_transaction', '<>', 'offline mandiri')->get();
        } elseif ($userRole == 'partner') {
            $data['booking'] = Booking::Status1()->WhereNull('bookings.deleted_at')->whereDate('bookings.created_at', $day)->Mitra()->with('packet', 'user', 'purchase_confirm')->join('profit_mitras', 'bookings.packet_id', '=', 'profit_mitras.paket_id')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->get();
        }

        // $data['booking'] = Booking::Status1()->WhereNull('bookings.deleted_at')->whereDate('created_at', $day)->with('user', 'packet', 'purchase_confirm')->get();
        // dd($data['booking']);
        if ($data['booking'] == null || count($data['booking']) < 1) {
            $data['empty'] = 'Data tidak ditemukan';
            return response()->json($data['empty']);
        } else {
            $data['profit'] = ProfitMitra::get();
            return response()->json($data);
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
     * @param  \App\Models\ProfitReport  $profitReport
     * @return \Illuminate\Http\Response
     */
    public function show(ProfitReport $profitReport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProfitReport  $profitReport
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $bookingOffline = PurchaseConfirm::find($request->id);
        return view('profit-report.edit', ['bookingOffline' => $bookingOffline]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseConfirm  $profitReport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PurchaseConfirm $purchase_confirm)
    {
        $validatedData = $request->validate([
            'nominal' => 'required|numeric'
        ]);

        $nominal = $validatedData['nominal'];
        $saldo = PurchaseConfirm::find($request->id);
        $booking = Booking::where('no_nota', $request->no_nota)->first();
        $total = ['nominal' => $saldo->nominal + $nominal];

        $statusPurchase = ($total['nominal'] >= $booking->total_purchase)
            ? Booking::STATUS_PURCHASE_FULL
            : Booking::STATUS_PURCHASE_DP;
        $saldo->update($total);
        $booking->update([
            'status_purchase' => $statusPurchase
        ]);

        flash('Data berhasil diperbarui', 'success');

        return redirect()->route('profitReport.indexpartner');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProfitReport  $profitReport
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProfitReport $profitReport)
    {
        //
    }

    public function mootareport($nominal)
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
