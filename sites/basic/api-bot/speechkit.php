<?php

$token = 't1.9euelZrOnp6PkZuTx8mPmJKbjI2Ple3rnpWakI3MjJPInJ2TyIySzMfLlpLl9PdofUtY-e9SFSGv3fT3KCxJWPnvUhUhr83n9euelZqJkcaVyZ2ZkcfKjcyKjsaNmO_8xeuelZqJkcaVyZ2ZkcfKjcyKjsaNmA.SRo2we6haeWZ4Z-JZp2X8RwCB70QBT7mxMVUfrELSgTEoTN4
4Pn4I7Dv3Kcr23svfnfZV7q9Jz_byRa0B4CHAg'; # IAM-токен
$folderId = "b1ghcntgeh0bvm7rkgqf"; # Идентификатор каталога
//$audioFileName = "speech.ogg";
$audioFileName = "https://cr45681.tmweb.ru/api-bot//assets/audio/1693162179-file_182.ogg";

 

    file_put_contents(__DIR__ . '/kittt.txt', print_r($audioFileName, true));

$file = fopen($audioFileName, 'rb');

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://stt.api.cloud.yandex.net/speech/v1/stt:recognize?lang=ru-RU&folderId=${folderId}&format=oggopus");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $token, 'Transfer-Encoding: chunked'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

curl_setopt($ch, CURLOPT_INFILE, $file);
curl_setopt($ch, CURLOPT_INFILESIZE, filesize($audioFileName));
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