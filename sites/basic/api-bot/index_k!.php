<?php

$token = 't1.9euelZrIzZKXj5iUy82OlJWezpOQle3rnpWakI3MjJPInJ2TyIySzMfLlpLl8_c2PEdY-e8xETBj_t3z93ZqRFj57zERMGP-zef1656Vmo_Nzs7MxomRnMqYipmeiovM7_zF656Vmo_Nzs7MxomRnMqYipmeiovM.RPc8XWokxJuVHchxi0kJTP3baq73Z7N5KbmNSLclEC5PvN
LECvoO0lQpj05W-tyU1LEh7HXTkZGpj1bH_DFfDg
4Pn4I7Dv3Kcr23svfnfZV7q9Jz_byRa0B4CHAg'; # IAM-токен
$folderId = "b1ghcntgeh0bvm7rkgqf"; # Идентификатор каталога
//$audioFileName = "speech.ogg";
$audioFileName = "https://cr45681.tmweb.ru/api-bot/assets/audio/1692709416-file_171.mp3";

 //file_put_contents(__DIR__ . '/kittt.txt', print_r($audioFileName, true));

    

$file = fopen($audioFileName, 'w');



file_put_contents(__DIR__ . '/kitfile.txt', print_r($file, true));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://stt.api.cloud.yandex.net/speech/v1/stt:recognize?lang=ru-RU&folderId=${folderId}&format=oggopus");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token, 'Transfer-Encoding: chunked'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

curl_setopt($ch, CURLOPT_FILE, $file);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($audioFileName));


file_put_contents(__DIR__ . '/kit_info_.txt', print_r($file, true));


$res = curl_exec($ch);
curl_close($ch);
$decodedResponse = json_decode($res, true);
if (isset($decodedResponse["result"])) {
    echo $decodedResponse["result"];
} else {
    echo "Error code: " . $decodedResponse["error_code"] . "\r\n";
    echo "Error message: " . $decodedResponse["error_message"] . "\r\n";
}

fclose($file);

?>