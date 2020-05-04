<?php

$key='db63f52c1a00d33cf143524083dd3ffd025d672e255cc683'; //this is demo key please change with your own key
$url='http://116.203.92.59/api/scheduler';
$img_url='https://my.woo-wa.com/wp-content/uploads/2018/12/Logo-Woo-WA-PNG-Berwarna-150px.png';
$data = array(
  "phone_no" =>'+6282130944260',
  "key"       =>$key,
  "sch_date" =>'2020-04-27 09:54',
  "api_type" =>'text', // (text, image_text, image, file)
  "message" =>'Selamat siang Farhan2',
  "url"       => ''
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
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Content-Type: application/json',
  'Content-Length: ' . strlen($data_string))
);
echo $res=curl_exec($ch);
curl_close($ch);
