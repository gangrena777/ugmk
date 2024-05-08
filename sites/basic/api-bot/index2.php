<?php

require_once 'constant.php';
require_once 'function.php';

 $data = file_get_contents('php://input');

 $data = json_decode($data, true);


/*
switch($message) {
    case '/test':  
    $inline_button1 = array("text"=>"Google url","url"=>"http://google.com");
    $inline_button2 = array("text"=>"work plz","callback_data"=>'/plz');
    $inline_keyboard = [[$inline_button1,$inline_button2]];
    $keyboard=array("inline_keyboard"=>$inline_keyboard);
    $replyMarkup = json_encode($keyboard); 
     sendMessage($chat_id, "ok", $replyMarkup);
    break;
}
switch($data){
    case '/plz':
    sendMessage($chat_id_in, "plz");
    break;
}

function sendMessage($chat_id, $message, $replyMarkup) {
  file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message) . '&reply_markup=' . $replyMarkup);
}
*/

if (!empty($data['message']['text'])) {

  file_put_contents(__DIR__ . '/message0.txt', print_r($data, true));

	$text = $data['message']['text'];


	$callback_query = $data['callback_query'];

	$dataZ = $callback_query['data'];
    $message_id = ['callback_query']['message']['message_id'];
    $chat_id_in = $callback_query['message']['chat']['id'];

      
 
	if (mb_stripos($text, 'getObjects') !== false) {

	   
        $contries = file_get_contents('https://cr45681.tmweb.ru/api/objects');

		$data_1 = json_decode($contries, true);

	    	//  file_put_contents(__DIR__ . '/message.txt', print_r($data_1, true));

		 uasort($data_1, function($a, $b){
          return $b['name'] <=> $a['name'];
        });
 
      
 

       $city = '';
       foreach ($data_1 as $key => $value) {

       	$city .= "<a  href='https://cr45681.tmweb.ru/objects/".$value['id']." '>".$value['name']."</>".PHP_EOL;
       	
       }
     
	   $keyboard = array(
	      array(
	         array('text'=>':like:','callback_data'=>'{"action":"/like","count":0,"text":":like:"}'),
	         array('text'=>':joy:','callback_data'=>'{"action":"/joy","count":0,"text":":joy:"}'),
	         array('text'=>':hushed:','callback_data'=>'{"action":"/hushed","count":0,"text":":hushed:"}'),
	         array('text'=>':cry:','callback_data'=>'{"action":"/cry","count":0,"text":":cry:"}'),
	         array('text'=>':rage:','callback_data'=>'{"action":"/rage","count":0,"text":":rage:"}')
	      )
	   ); 

     


		getTGApi(
			'sendMessage', 
			array(
				'chat_id' => $data['message']['chat']['id'],
				'text' => $city,
				  'disable_web_page_preview' => false,
				    'parse_mode' => 'HTML',
                 'reply_markup' => json_encode(array('inline_keyboard' => $keyboard))
			)
		);

 
		exit();	
	} 


	if (mb_stripos($text, 'updateObjects') !== false) {

        $contries2 = file_get_contents('https://cr45681.tmweb.ru/api/objects');

		$data_11 = json_decode($contries2, true);
        uasort($data_11, function($a, $b){
          return $b['name'] <=> $a['name'];
        });
        $objects = [];
        foreach ($data_11 as $key => $value) {
           $objects[] = [['text'=>$value['name'].'_'.$value["id"],'callback_data'=>"{'/objects/'".$value["id"]."}" ]];
       	}

       	$keyboard =array($objects);
     
        //file_put_contents(__DIR__ . '/message.txt', print_r($data, true));
    	
        getTGApi(
			'sendMessage', 
			array(
				'chat_id' => $data['message']['chat']['id'],
				'text' =>'Check update item',
				// 'disable_web_page_preview' =>false,
				 
                'reply_markup' => json_encode(array('inline_keyboard' => $objects))
			)
		);

 
		exit();	
	}

	if (mb_stripos($text, '/objects/4') !== false) {

		   file_put_contents(__DIR__ . '/message6.txt', print_r($text, true));

       // $obj = file_get_contents('https://cr45681.tmweb.ru/api/objects/4');

		//$data_obj = json_decode($obj, true);
  
     
       // $string = "name ".$data_obj['name']." communication ".$data_obj['communication'];
    	
        getTGApi(
			'sendMessage', 
			array(
				'chat_id' => $chat_id_in,
				  //$data['message']['chat']['id'],
				'text' =>"object  ".$value['id']
				// 'disable_web_page_preview' =>false,
				 
               // 'reply_markup' => json_encode(array('inline_keyboard' => $objects))
			)
		);

 
		exit();	
	}

} 






?>