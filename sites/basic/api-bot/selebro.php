<? 

$recordingurl = $_REQUEST["recording"]; // passed as a GET parameter
$recording = file_get_contents($recordingurl);
$b64recording = base64_encode($recording);
$api_token = 'put_your_token_here';
$api_url = 'https://api.silero.ai/transcribe';

$payload = array(
    "api_token" => $api_token,
    "payload" => $b64recording,
    "remote_id" => "empty",
    "am" => "general",
    "lm" => "general",
    "format" => "wav",
    "channels" => 2,
    "sample_rate" => 8000,
    "cutter_id" => "",
    "align" => false,
    "nbest" => 0,
    "diarization" => false,
    "history" => "[]"
);

$postdata = json_encode($payload);

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json", "Content-Length: " . strlen($postdata)));

$result = curl_exec($ch);
curl_close($ch);