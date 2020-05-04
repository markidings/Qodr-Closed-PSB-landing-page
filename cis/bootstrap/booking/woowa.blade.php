<?php

$key = '44d5d46d66aa02a048efc7b3abb0f5bc32ac3f76d401d986';
$url = 'http://116.203.92.59/api/async_send_image_url';
$img_url = 'https://my.woo-wa.com/wp-content/uploads/2018/12/Logo-Woo-WA-PNG-Berwarna-150px.png';
$data = array(
    "phone_no" => '+6282130944260',
    "key"        => $key,
    "url"        => $img_url,
    "message"    => 'DEMO AKUN WOOWA. tes woowa api v3.0 mohon di abaikan'
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