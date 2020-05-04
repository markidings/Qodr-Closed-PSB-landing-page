<?php

sendMessage($_POST);

function tg($url, $params)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url . $params);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);
    $content = curl_exec($curl);
    curl_close($curl);
    return json_decode($content, true);
}

function sendMessage($test){
    $key = 'bot1198090162:AAEPzbn5vb4FQflphGazq2lQTAGRDJtNhjE';
    $chat = tg("https://api.telegram.org/$key/getUpdates", '');
    
    if ($chat['ok']) {
        $text = 'Nama depan = ' . $test['depan'] . " Nama belakang" . $test['belakang'];
        $text = urlencode($text); 
    }
    
    return tg("https://api.telegram.org/$key/sendMessage", "?chat_id=-410231225&text=$text");
    
}
