<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PurchaseConfirm;
use App\Models\Booking;
use DB;
use App\Models\Broadcast;

class PurchaseConfirmPartnerController extends Controller
{
    public function index()
    {
        // $datas = PurchaseConfirm::with('booking')->get();
        $datas = Booking::Mitra()->join('purchase_confirmations', 'bookings.no_nota', '=', 'purchase_confirmations.no_nota')->where('purchase_confirmations.deleted_at', NULL)->whereNotNull('status_purchase')->where('type_payment', 'offline')->get();
        // dd($datas); 
        return view('purchase-confirm-partner.index', compact('datas'));
    }

    public function create()
    {
        // hanya tampilkan booking yg belum ada konfirmasi pembayaran
        $bookings = Booking::Status1()->Mitra()->whereNull('status_purchase')->where('type_payment', 'offline')->get();
        // dd($bookings);
        return view('purchase-confirm-partner.create', compact('bookings'));
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
        $plus = rand(99,999);
        $dp = $nextPayment + $plus; 
        $validatedData['paid_off'] = $dp;
        PurchaseConfirm::create($validatedData);
        $statusPurchase = ($nominal >= $booking->total_purchase)
            ? Booking::STATUS_PURCHASE_FULL
            : Booking::STATUS_PURCHASE_DP;
        $booking->update([
            'status_purchase' => $statusPurchase
        ]);


        flash('Data berhasil ditambahkan', 'success');

        return redirect()->route('purchase-confirms-partner.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(PurchaseConfirm $purchase_confirms_partner)
    {
        return view('purchase-confirm-partner.edit', compact('purchase_confirms_partner'));
    }

    public function update(Request $request, PurchaseConfirm $purchase_confirms_partner)
    {
        $validatedData = $request->validate([
            'nominal' => 'required|numeric'
        ]);
        $nominal = $validatedData['nominal'];
        $saldo = PurchaseConfirm::where('no_nota', $purchase_confirms_partner->no_nota)->first();
        $booking = Booking::where('no_nota', $purchase_confirms_partner->no_nota)->first();
        $total = ['nominal' => $saldo->nominal + $nominal];
            $nextPayment = $booking->total_purchase - $total['nominal'];
            $total['paid_off'] = $nextPayment;
        $statusPurchase = ($total['nominal'] >= $booking->total_purchase)
            ? Booking::STATUS_PURCHASE_FULL
            : Booking::STATUS_PURCHASE_DP;
        $purchase_confirms_partner->update($total);
        $booking->update([
            'status_purchase' => $statusPurchase
        ]);

        flash('Data berhasil diperbarui', 'success');

        return redirect()->route('purchase-confirms-partner.index');
    }

    public function destroy(PurchaseConfirm $purchase_confirms_partner)
    {
        $purchase_confirms_partner->delete();

        flash('Data berhasil dihapus.', 'success');

        return redirect()->back();
    }
}
