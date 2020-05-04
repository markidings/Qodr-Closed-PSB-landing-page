<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

use App\Models\Booking;
use App\Models\SettingBankAccount;
use App\Models\Paket;
use App\Models\Broadcast;

class WoowaService
{
    protected $apiKey = "e77438221c95ede5194ae2bcf724732a6221cc3d3f1f5e8a";
    protected $woowaURL = "http://116.203.92.59/api/send_message";
    protected $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'headers' => ['Content-Type' => 'application/json']
        ]);
    }

    public function sendFullFormBookingLink(Booking $booking)
    {
        $template = "Assalamu'alaikum *$booking->name*,  terimakasih sudah mempercayakan pelaksanaan akikah bersama akikahkita.com, selanjutnya kami akan mengirimkan notifikasi berikutnya kepada anda.";
 
        if (substr(trim($booking->no_whatsapp), 0, 1) == '0') {
            $booking->no_whatsapp = '+62'. substr($booking->no_whatsapp, 1, strlen($booking->no_whatsapp));
        }

        //History Message
        $data = [
            'message' => $template,
            'phone_number' => $booking->no_whatsapp,
            'type' => 'transaction'
        ];
        
        $history = Broadcast::create($data);

        return $this->httpClient->post($this->woowaURL, [
            'body' => json_encode([
                'phone_no' => $booking->no_whatsapp,
                'key' => $this->apiKey,
                'message' => $template
            ])
        ]);
    }

    public function sendPaymentConfirm(Booking $booking)
    {
        $bankAccount = SettingBankAccount::first();
        $paket = Paket::where('id', $booking->packet_id)->first();

        $nominal = ($booking->type_purchase == 'dp') ? $booking->total_purchase / 2 : $booking->total_purchase;

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
        
        Terimakasih.";

        if (substr(trim($booking->no_whatsapp), 0, 1) == '0') {
            $booking->no_whatsapp = '+62'. substr($booking->no_whatsapp, 1, strlen($booking->no_whatsapp));
        }

        //History Message
        $data = [
            'message' => $template,
            'phone_number' => $booking->no_whatsapp,
            'type' => 'transaction'
        ];
        
        $history = Broadcast::create($data);

        return $this->httpClient->post($this->woowaURL, [
            'body' => json_encode([
                'phone_no' => $booking->no_whatsapp,
                'key' => $this->apiKey,
                'message' => $template
            ])
        ]);
    }

    public function sendMoota($data)
    {
        if (substr(trim($data['phone_number']), 0, 1) == '0') {
            $data['phone_number'] = '+62'. substr($data['phone_number'], 1, strlen($data['phone_number']));
        }

        $key= $this->apiKey;
        $url= $this->woowaURL;
        $datasend = array(
        "phone_no"=> $data['phone_number'],
        "key"		=>$key,
        "message"	=> $data['message']
        );
        $data_string = json_encode($datasend);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 360);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
        );
        $res=curl_exec($ch);
        curl_close($ch);

        $databroadcast = [
            'message' => $data['message'],
            'phone_number' => $data['phone_number'],
            'type' => $data['type']
        ];
        
        $history = Broadcast::create($databroadcast);
        return $res;
    }
}
