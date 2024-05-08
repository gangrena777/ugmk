<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once 'constant.php';
require_once 'functions.php';
require_once 'settings.php';

 $data = file_get_contents('php://input');

 $data = json_decode($data, true);

file_put_contents(__DIR__ . '/main_data.txt', print_r($data, true));



writeLogFile($data, false);

///if isset callback_query

$update_id = $data['update_id'];

$objects = file_get_contents('https://cr45681.tmweb.ru/api/objects');
    $data_obj = json_decode($objects, true);


if(isset($data['callback_query'])){  

	$callback_query = $data['callback_query']; 
	$dataZ = $callback_query['data'];

	$message_id = $callback_query['message']['message_id'];
    $chat_id_in = $callback_query['message']['chat']['id'];


    $user_id    = $callback_query['from']['id'];

    file_put_contents(__DIR__ . '/messageCallback_query.txt', print_r($callback_query, true));
}
else{  //if simple massage   
	$dataZ = false;

	$chat_id = $data['message']['chat']['id'];

    $message = $data['message']['text'];
    $message_id = $data['message']['message_id'];
    $user_id = $data["message"]["from"]["id"];

 

    switch($message) {


	    case '/getObjects':  

	        uasort($data_obj, function($a, $b){

	          return $b['name'] <=> $a['name'];
	        });
	        $objectZ = [];

			foreach ($data_obj as $key => $value) {

	           $objectZ[] = [['text'=>$value['name'],'callback_data'=>"objects/get/".$value["id"] ]];
	       	}


	        getTGApi(
				'sendMessage', 
				array(
					'chat_id' => $data['message']['chat']['id'],
					'text' =>'Действующие объекты',
					'disable_web_page_preview' =>false,
					 
	                'reply_markup' => json_encode(array('inline_keyboard' => $objectZ))
				)
			);

			file_put_contents(__DIR__ . '/messageGetObject.txt', print_r($data, true));
	    break;

	    default:

	        //file_put_contents(__DIR__ . '/messageDefault.txt', print_r($data, true));

	        if($message !==''){

		      	if( $user_data = get_user_qwestion_type($connect, $chat_id, $update_id)){

		      		  file_put_contents(__DIR__ . '/messageGUQT.txt', print_r($user_data, true));

  						// если это был вопрос
		      	 	if($user_data['qwestion_data'] !== 0 ){
		                    switch($user_data['qwestion_data']){
		                           case 'add_to_info_field':
		                              //добавить данные в поле info


                                      $info = get_object_field($connect, 'object', 'info',$user_data['object_id']);
                                      
                                      $mess = $info['info']."\r\n". $message;
                                       // file_put_contents(__DIR__ . '/isUpdate2.txt', print_r($info, true));


		                              $upd = update_object_field($connect, 'object', 'info', $mess, $user_data['object_id']);
										if($upd){
		                              	 	//file_put_contents(__DIR__ . '/isUpdate3.txt', print_r($upd, true));


		                              	    $res = reset_qwestionData($connect, $chat_id,  $update_id);
			                                if($res){

			                                		getTGApi(
										                   'sendMessage', 
										                        array(
											                            'chat_id' => $data['message']['chat']['id'],
											                            'text' =>'Информация об объекте изменена',
											                   
										                        )
						                    		);
						                    		    		getTGApi(
										                   'forwardMessage', 
										                        array(
											                            'chat_id' => $data['message']['chat']['id'],
											                             'from_chat_id' => $user_data['chat_id'],
																			'message_id' =>$user_data['message_id']
											                           
											                   
										                        )
						                    		);


			                                }//if($res)
		                              	}//if($upd)

		                              

		                                 //если $user_data['qwestion_data']=='add_to_info_field'  обнуляем данные  - делаем 0


		                            break;    


		                    }//  switch('qwestion_data')
		      	 	}
		      	}
	        }

				
		break;
    }///switch($message)

}

 



if($dataZ){

	$data_info = explode("/", $dataZ);
	$action = $data_info[1];
	$id = $data_info[2];




	   file_put_contents(__DIR__.'/messageCallbackINFO.txt', print_r($data_info, true));

	switch ($action) {
		case 'get':
            if($id){

	           // $object = file_get_contents('https://cr45681.tmweb.ru/api/objects/view?id='.$id);
	           // $data_obj = json_decode($object, true);

	                    //  file_put_contents(__DIR__ . '/messageGET.txt', print_r($data_obj, true));

	                 $obj = get_object_by_id($connect, $id);

	                       file_put_contents(__DIR__ . '/id.txt', print_r($obj['buttons'], true));
	                  
	                        getTGApi(
								'sendMessage', 
								array(
									'chat_id' => $chat_id_in,
									
									'text' =>$obj['obj'],

									 'disable_web_page_preview' =>false,

									'reply_markup' => json_encode(array('inline_keyboard' => $obj['buttons'] ))
									   // 'reply_markup' => json_encode(array('keyboard' => $buttons_action))
								)
							);
	        }
			break;

		case 'update':

		    if($id){


		        //$postdata = http_build_query(
				// 	    array(
				// 	        'var1' => 'some content',
				// 	        'var2' => 'doh'
				// 	    )
				// );

				// $opts = array('http' =>
				//     array(
				//         'method'  => 'POST',
				//         'header'  => 'Content-Type: application/x-www-form-urlencoded',
				//         'content' => $postdata
				//     )
				// );

				// $context  = stream_context_create($opts);

				// $result = file_get_contents('http://example.com/submit.php', false, $context);

		    	//file_put_contents(__DIR__ . '/messageUPD.txt', print_r($id, true));

		    		   
	         

	                        getTGApi(
								'sendMessage', 
								array(
									'chat_id' => $chat_id_in,
									
									'text' =>"will be update ".$id." item",
									// 'disable_web_page_preview' =>false,

									// 'reply_markup' => json_encode(array('inline_keyboard' => $buttons_action))
								)
							);
	        }


			break;

		case 'delete':

		    if($id){

	                        getTGApi(
								'sendMessage', 
								array(
									'chat_id' => $chat_id_in,
									
									'text' =>"will be delete ".$id." item",
									//'disable_web_page_preview' =>false,

									//'reply_markup' => json_encode(array('inline_keyboard' => $buttons_action))
								)
							);
	        }

			break;
		case 'addinfo':

		        if($id){

		    	            //file_put_contents(__DIR__ . '/messageAddInfo.txt', print_r($data, true));
		    	            //сохраняем в бд инфо, что пользователю был задан вопрос(задание)...

		    	            if( add_to_info($connect, $user_id, $chat_id_in, $message_id, $update_id, $id, "add_to_info_field") ){
                             		getTGApi(
										'sendMessage', 
												array(
													'chat_id' => $chat_id_in,
													
													'text' =>"Добавить данные к объекту с  id=".$id." ",
													
												)
									);
                            }
                }


			break;


		
		default:
				file_put_contents(__DIR__ . '/messageCallbackDefault.txt', print_r($data, true));
			break;
	}
}









?>