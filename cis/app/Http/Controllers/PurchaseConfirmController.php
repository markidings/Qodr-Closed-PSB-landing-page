<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PurchaseConfirm;
use App\Models\Booking;
use DB;
use App\Models\Broadcast;

class PurchaseConfirmController extends Controller
{
    public function index()
    {
        // $datas = PurchaseConfirm::with('booking')->get();
        $datas = DB::table('bookings')->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->where('purchase_confirmations.deleted_at', NULL)->whereNotNull('status_purchase')->where('status_transaction', '!=', 'offline mandiri')->get();
        // dd($datas); 
        return view('purchase-confirm.index', compact('datas'));
    }

    public function create()
    {
        // hanya tampilkan booking yg belum ada konfirmasi pembayaran
        $bookings = Booking::Status1()->whereNull('status_purchase')->where('status_transaction', '!=', 'offline mandiri')->get();
        // dd($bookings);
        return view('purchase-confirm.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'booking_id' => 'required',
            'nominal' => 'required|numeric'
        ]);
        $bookingID = $request->booking_id;
        $nominal = $validatedData['nominal'];
        $booking = Booking::find($bookingID);
        $validatedData['no_nota'] = $booking->no_nota;

        $nominal = $request->nominal;
        $nextPayment = $booking->total_purchase - $nominal;
        $plus = rand(99, 999);
        $dp = $nextPayment + $plus;
        $validatedData['paid_off'] = $dp;
        PurchaseConfirm::create($validatedData);
        $statusPurchase = ($nominal >= $booking->total_purchase)
            ? Booking::STATUS_PURCHASE_FULL
            : Booking::STATUS_PURCHASE_DP;
        $booking->update([
            'status_purchase' => $statusPurchase
        ]);

        if ($request->nominal < $booking->total_purchase) {
            $template = "Terimakasih telah membayar DP sebesar *" . format_rupiah($nominal) . "*, pesanan anda akan segera di proses. Jangan lupa untuk membayar kekurangan anda sebesar " . format_rupiah($dp) . ".";
        } else {
            $template = "Terimakasih telah membayar LUNAS sebesar *" . format_rupiah($nominal) . "*, pesanan anda akan segera di proses.";
        }

        if (substr(trim($booking->no_whatsapp), 0, 1) == '0') {
            $noWa = '+62' . substr($booking->no_whatsapp, 1, strlen($booking->no_whatsapp));
        }

        $data = array(
            "phone_no" => $noWa,
            "key" => 'e77438221c95ede5194ae2bcf724732a6221cc3d3f1f5e8a',
            "message" => $template
        );
        // echo "<pre>".print_r($data,1)."</pre>";die();
        // $data_string = json_encode($data);
        // $url = 'http://116.203.92.59/api/async_send_message';
        // $ch = curl_init($url);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_VERBOSE, 0);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        // curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        // curl_setopt(
        //     $ch,
        //     CURLOPT_HTTPHEADER,
        //     array(
        //         'Content-Type: application/json',
        //         'Content-Length: ' . strlen($data_string)
        //     )
        // );

        // $response = curl_exec($ch);
        // $err = curl_error($ch);
        // curl_close($ch);

        $data = [
            'message' => $template,
            'phone_number' => $noWa,
            'type' => 'transaction'
        ];
        $history = Broadcast::create($data);

        flash('Data berhasil ditambahkan', 'success');

        return redirect()->route('purchase-confirms.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(PurchaseConfirm $purchase_confirm)
    {
        return view('purchase-confirm.edit', compact('purchase_confirm'));
    }

    public function update(Request $request, PurchaseConfirm $purchase_confirm)
    {
        $validatedData = $request->validate([
            'nominal' => 'required|numeric'
        ]);
        $nominal = $validatedData['nominal'];
        $saldo = PurchaseConfirm::where('no_nota', $purchase_confirm->no_nota)->first();
        $booking = Booking::where('no_nota', $purchase_confirm->no_nota)->first();
        $total = ['nominal' => $saldo->nominal + $nominal];
        $nextPayment = $booking->total_purchase - $total['nominal'];
        $total['paid_off'] = $nextPayment;
        $statusPurchase = ($total['nominal'] >= $booking->total_purchase)
            ? Booking::STATUS_PURCHASE_FULL
            : Booking::STATUS_PURCHASE_DP;
        $purchase_confirm->update($total);
        $booking->update([
            'status_purchase' => $statusPurchase
        ]);

        flash('Data berhasil diperbarui', 'success');

        return redirect()->route('purchase-confirms.index');
    }

    public function destroy(PurchaseConfirm $purchase_confirm)
    {
        $purchase_confirm->delete();

        flash('Data berhasil dihapus.', 'success');

        return redirect()->back();
    }
}
