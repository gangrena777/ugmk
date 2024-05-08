<?php

$token = '<IAM-токен>'; # Укажите IAM-токен.
$folderId = "<идентификатор каталога>"; # Укажите идентификатор каталога.

$url = "https://tts.api.cloud.yandex.net/speech/v1/tts:synthesize";
$headers = ['Authorization: Bearer ' . $token];
$post = array(
    'text' => "Я Яндекс Спичк+ит. Я могу превратить любой текст в речь. Теперь и в+ы — можете!",
    'folderId' => $folderId,
    'lang' => 'ru-RU',
    'voice' => 'filipp');

$ch = curl_init();

curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HEADER, false);
if ($post !== false) {
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
}
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    print "Error: " . curl_error($ch);
}
if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
    $decodedResponse = json_decode($response, true);
    echo "Error code: " . $decodedResponse["error_code"] . "\r\n";
    echo "Error message: " . $decodedResponse["error_message"] . "\r\n";
} else {
    file_put_contents("speech.ogg", $response);
}
curl_close($ch);
?>