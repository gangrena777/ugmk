<?php

//https://api.telegram.org/bot6520239724:AAGd2ef-NZUKWYr2zfJbDHxlbGiaabKKSPM/setWebhook?url=https://cr45681.tmweb.ru/api-bot/index.php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once 'constant.php';
require_once 'functions.php';
require_once 'settings.php';


require $_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php';


use GuzzleHttp\Client;



$data = file_get_contents('php://input');

$data = json_decode($data, true);


file_put_contents(__DIR__ . '/main_data.txt', print_r($data, true));



writeLogFile($data, false);

///if isset callback_query

$update_id = $data['update_id'];




if(isset($data['callback_query'])){  

	$callback_query = $data['callback_query']; 
	$dataZ = $callback_query['data'];

	$message_id = $callback_query['message']['message_id'];
    $chat_id_in = $callback_query['message']['chat']['id'];


    $user_id    = $callback_query['from']['id'];

    //file_put_contents(__DIR__ . '/messageCallback_query.txt', print_r($callback_query, true));
}
else{  //if simple massage   
	$dataZ = false;

	$chat_id = $data['message']['chat']['id'];

    $message = $data['message']['text'];
    $message_id = $data['message']['message_id'];
    $user_id = $data["message"]["from"]["id"];


    $photo = $data['message']['photo'];

    $voice = $data['message']['voice'];



 

    switch($message) { 
    	case '/help' :

    	 $mess = 'Краткая инструкция'."\r\n";
    	 $mess .= " '/getObjects' - выводит список объектов в виде меню"."\r\n";
    	 $mess .= " '/createObject' - создать новый обект";

    		getTGApi(
				'sendMessage', 
				array(
					'chat_id' => $data['message']['chat']['id'],
					'text' =>$mess,
					'disable_web_page_preview' =>false,
					 
	               // 'reply_markup' => json_encode(array('inline_keyboard' => $objectZ))
				)
			);

        break;

	    case '/getObjects':  

	        $objectZ = get_api_objects();



	        getTGApi(
				'sendMessage', 
				array(
					'chat_id' => $data['message']['chat']['id'],
					'text' =>'Действующие объекты',
					'disable_web_page_preview' =>false,
					 
	                'reply_markup' => json_encode(array('inline_keyboard' => $objectZ))
				)
			);

			//file_put_contents(__DIR__ . '/messageGetObject.txt', print_r($data, true));
	    break;

	    case '/createObject' :

	       $link ="<a  href='https://cr45681.tmweb.ru/objects/create'>=>Создать обьект в редакторе</a>";
	        getTGApi(
				'sendMessage', 
				array(
					'chat_id' => $data['message']['chat']['id'],
					'text' =>$link,
					'disable_web_page_preview' =>false,
					'parse_mode' =>'html'
					 
	               
				)
			);
	    break;

	    default:

	          //file_put_contents(__DIR__ . '/messageDefault.txt', print_r($data, true));

	        if($message !=='' || ( $photo && !empty($photo)) ){



		      	if( $user_data = get_user_qwestion_type($connect, $chat_id, $update_id) ){

		      		    file_put_contents(__DIR__ . '/messageGUQT.txt', print_r($user_data, true));

  						 // если это был вопрос
			      	 	if($user_data['qwestion_data'] !== 0 ){
			                    switch($user_data['qwestion_data']){
			                           case 'add_to_info_field':
			                               //добавить данные в поле info


	                                      $info = get_object_field($connect, 'object', 'info',$user_data['object_id']);
	                                               //если в ответ на прислали фото
		                                       if($photo && !empty($photo)){

				                                      	$photo = array_pop($data['message']['photo']);
														$res = sendTelegram(
															'getFile', 
															array(
																'file_id' => $photo['file_id']
															)
														);


														    $res = json_decode($res, true);
															if ($res['ok']) {
																
															
														 
																 if ($path = getTGApiPhoto($res['result']['file_path'])) {

																	// file_put_contents(__DIR__ . '/messagephoto.txt', print_r($path, true));


																	$photo_ids = get_object_field($connect, 'object', 'photo_ids',$user_data['object_id']);

																	$add_photo_id = $photo_ids['photo_ids'].",".$path;


																	$upd_photos = update_object_field($connect, 'object', 'photo_ids',$add_photo_id , $user_data['object_id']);
																			if($upd_photos){

																				sendTelegram(
																					'sendMessage', 
																						array(
																						'chat_id' => $data['message']['chat']['id'],
																						'text' => 'Фото сохранено'
																						)
																				);	

																			}

															     }

															     $mess = $info['info']."\r\n"."картинка_".$path;
															}
											    }

		                                        else{
													
													$mess = $info['info']."\r\n". $message;

		                                        }
                                                $upd = update_object_field($connect, 'object', 'info', $mess, $user_data['object_id']);
			                              	 	   //file_put_contents(__DIR__ . '/isUpdate3.txt', print_r($upd, true));

			                                    if($upd){
			                              	    	$res = reset_qwestionData($connect, $chat_id,  $update_id);
					                                    if($res){

					                                		getTGApi(
												                   'sendMessage', 
												                        array(
													                            'chat_id' => $data['message']['chat']['id'],
													                            'text' =>'Информация об объекте изменена',
													                   
												                        )
								                    		);

								                    		$obj = get_object_by_id($connect, $user_data['object_id']);
								                    		$buttons = get_object_buttons_by_id($connect, $user_data['object_id']);


								                    	

								                    		getTGApi(
																		'sendMessage', 
																				array(
																					'chat_id' => $data['message']['chat']['id'],
																					
																					'text' =>$obj['obj'],

																				
																				)
																	);
								                    			if( isset($obj['photo_ids']) && $obj['photo_ids'] !=='' ){

								                    			    $ids = explode(',',$obj['photo_ids']);

								                    			    file_put_contents(__DIR__ . '/messagePhoto_is_arr.txt', print_r($ids, true));
								                    			    foreach ($ids as $id => $value) {


								                    					$url = __DIR__ .'/assets/photos/'.$value; 

								                    					file_put_contents(__DIR__ . '/path', print_r($url, true));

                                                                        $caption = "картинка_".$value;




                                                                        sendTelegram(
																			'sendPhoto', 
																				array(
																					 	'chat_id' => $data['message']['chat']['id'],
																	                    'photo' => curl_file_create($url), 
																	                    'caption' => $caption, 
																	                    'parse_mode' => "html"
																				)
																		);	
								                    			    }
								                    		    }

								                    		getTGApi(
																		'sendMessage', 
																				array(
																					'chat_id' => $data['message']['chat']['id'],
																					
																					'text' =>"----------меню-------- :",

																					'disable_web_page_preview' =>false,
																					 'resize_keyboard' => false,

																					'reply_markup' => json_encode(array('inline_keyboard' => $buttons['buttons'] ))
																					  
																				)
																	);
														
	  	
								                    	}//if $res	    


			                              	    }     //if($upd)

			                              

			                                       //если $user_data['qwestion_data']=='add_to_info_field'  обнуляем данные  - делаем 0


			                           break;    


			                    }//  switch('qwestion_data')
			      	 	}
		      	}
	        }
	        if($voice  && !empty($voice)){

	        	    $file_audio = $voice['file_id'];
	        		$token ='02zn8NurYo2Ia1AOjwOu4TSuXNpp7VBAdj4NCcHXyJuPQaaIFimZ2mdpwNjrJB6BZnUrRhWS9Px6EXNtturdU_EkxMyl8';

            		$res = sendTelegram(
											'getFile', 
											array(
													'file_id' => $file_audio
											)
										);


		    		$ress = json_decode($res, true);
		    		//if (!$ress || !isset($ress["result"]["file_path"])) return false;

		    		$file_pathV = $ress["result"]["file_path"];

		    		$file_id = $ress['result']['file_id'];

			    		if($path = getTGApiAudio($file_pathV)){

                                    
			    		        
									getTGApi(
									   'sendMessage', 
									        array(
									               'chat_id' => $data['message']['chat']['id'],
									               'text' =>'Голосовое сообщение получено и сохранено на сервере '.$path,
									        
									        )
									);


	                                $fileUrl = __DIR__ . '/assets/audio/'.$path;

	                                $new_path = preg_replace('"\.oga$"', '.mp3', $path); 


	                                $newfileUrl = __DIR__ . '/assets/audio/'.$new_path;
	                              
    
                                    file_put_contents(__DIR__ . '/old_path.txt', print_r($path, true));
                                    file_put_contents(__DIR__ . '/new_path.txt', print_r($new_path, true));
                                    // Конвертируем аудио в подходящий формат
	
								     $cmd = "ffmpeg  -i $fileUrl  $newfileUrl";

		                    
								    file_put_contents(__DIR__ . '/cmd.txt', print_r($cmd, true));
									$ttt = exec($cmd);

		                            file_put_contents(__DIR__ . '/ttt.txt', print_r($ttt, true));

	                                $fileUrl2 = "https://cr45681.tmweb.ru/api-bot/assets/audio/$new_path";

										$client = new Client([
													    'base_uri' => 'https://api.rev.ai/speechtotext/v1/',
													    'headers' => ['Authorization' => "Bearer $token"]
													]);

												
													$response = $client->request(
													    'POST',
													    'jobs',
													    ['json' => ['source_config' => ['url' => $fileUrl2]]]
													
													)
													->getBody()
													->getContents();

					     				$api_data = json_decode($response, true);
								  
								  		file_put_contents(__DIR__ .'/response_data.txt', print_r($api_data, true));

								  		$id = $api_data['id'];

								  		file_put_contents(__DIR__ .'/response_id.txt', $id);

								  		   getTGApi(
													   'sendMessage', 
													        array(
													               'chat_id' => $data['message']['chat']['id'],
													               'text' =>'Голосовое сообщение отправленно на расшифровку',
													        
													        )
													);

										sleep(20);

										////what  status   //////////////////////////			
												    
										$client2 = new Client([
										    'base_uri' => 'https://api.rev.ai/speechtotext/v1/',
										    'headers' => ['Authorization' => "Bearer $token"]
										]);

					     				// send GET request and get response body
										$response2 = $client2->request(
										    'GET',
										    "jobs/$id"
										  
										)
										->getBody()
										->getContents();

										$api_data2 = json_decode($response2, true);
										file_put_contents(__DIR__ .'/resp2_status.txt', $api_data2['status']);
										/// ----what status  /////////////////
			                            
			       						///if status of transcription
										if( $api_data2['status'] == 'transcribed'){
											// create client
											$client3 = new Client([
											    'base_uri' => 'https://api.rev.ai/speechtotext/v1/',
											    'headers' => ['Authorization' => "Bearer $token"]
											]);

											// send GET request and get response body
											$response3 = $client3->request(
											    'GET',
											     "jobs/$id/transcript",
											    
											    ['headers' => ['Accept' => 'application/vnd.rev.transcript.v1.0+json']]
											)
											->getBody()
											->getContents();

											// decode response JSON and print
											$res = json_decode($response3, true);



											/////make text  /////////

											$str = '';
											foreach ($res['monologues'] as $key => $item) {
												
												foreach ($item['elements'] as $key => $value) {
													//if($value['type'] =='text'){
														$str .= $value['value'];
													//}


												}
												$str .= PHP_EOL;
											}

											/////----------  ////////

											file_put_contents(__DIR__ .'/voice_text_result2.txt', print_r($str, true));

											getTGApi(
													   'sendMessage', 
													        array(
													               'chat_id' => $data['message']['chat']['id'],
													               'text' =>$str,
													        
													        )
											);
										}///end  if status of transcription
										else{
											      getTGApi(
													   'sendMessage', 
													        array(
													               'chat_id' => $data['message']['chat']['id'],
													               'text' =>'Сообщение еще не расшифровано или ошибка при шифровании',
													        
													        )
													);

										}


		                }

		    }
	
		    break;
    }///switch($message)

}

 



if($dataZ){

	$data_info = explode("/", $dataZ);
	$object_of_action = $data_info[0];
	$action = $data_info[1];
	$id = $data_info[2];




	   file_put_contents(__DIR__.'/messageCallbackINFO.txt', print_r($data_info, true));
    if($object_of_action =='objects'){

    	switch ($action) {
				case 'get':
		            if($id){

			           			// $object = file_get_contents('https://cr45681.tmweb.ru/api/objects/view?id='.$id);
			           			// $data_obj = json_decode($object, true);

			                    //  file_put_contents(__DIR__ . '/messageGET.txt', print_r($data_obj, true));

			                 $obj = get_object_by_id($connect, $id);
			                 $buttons = get_object_buttons_by_id($connect, $id);

			                        getTGApi(
										'sendMessage', 
										array(
											'chat_id' => $chat_id_in,
											
											'text' => $obj['obj'],

											//'disable_web_page_preview' => false,

											//'reply_markup' => json_encode(array('inline_keyboard' => $buttons['buttons']))
											 
										)
									);

									if( isset($obj['photo_ids']) && $obj['photo_ids'] !=='' ){

								                    			$ids = explode(',',$obj['photo_ids']);
																foreach ($ids as $id => $value) {


								                    					$url = __DIR__ .'/assets/photos/'.$value; 

								                    					file_put_contents(__DIR__ . '/path', print_r($url, true));

                                                                        $caption = "КАРТИНКА_".$id;

                                                                        sendTelegram(
																			'sendPhoto', 
																				array(
																					 	'chat_id' => $chat_id_in,
																	                    'photo' => curl_file_create($url), 
																	                    'caption' => $caption, 
																	                    'parse_mode' => "html"
																				)
																		);	
								                    			}
								    }


									getTGApi(
											'sendMessage', 
												array(
													'chat_id' => $chat_id_in,
																					
													'text' =>"----------меню-------- :",

													'disable_web_page_preview' =>false,
													'resize_keyboard' => false,

													'reply_markup' => json_encode(array('inline_keyboard' => $buttons['buttons'] ))
																					  
													)
									);
			        }
					break;

				case 'update':

				    if($id){
				    	    $link ="<a  href='https://cr45681.tmweb.ru/objects/update?id=$id'>=>Изменить обьект в редакторе</a>";

			                        getTGApi(
										'sendMessage', 
										array(
											'chat_id' => $chat_id_in,
											
											'text' =>"For update object with id=".$id." use link ".$link,
											'parse_mode' =>'html'
											// 'disable_web_page_preview' =>false,

											// 'reply_markup' => json_encode(array('inline_keyboard' => $buttons_action))
										)
									);
			        }


					break;

				case 'delete':

				    if($id){

				    	$delete_obj = delete_obj_by_id($connect,$id);
				    	if($delete_obj){

				    			    getTGApi(
										'sendMessage', 
										array(
											'chat_id' => $chat_id_in,
											
											'text' =>"object with id=".$id."  was successfully delete",
											//'disable_web_page_preview' =>false,

											//'reply_markup' => json_encode(array('inline_keyboard' => $buttons_action))
										)
									);

				    	}


			        }

					break;
				case 'addinfo':

				        if($id){

				    	            //file_put_contents(__DIR__ . '/messageAddInfo.txt', print_r($data, true));
				    	            //сохраняем в бд инфо, что пользователю был задан вопрос(задание)...

				    	            if(add_to_info($connect,$user_id,$chat_id_in,$message_id,$update_id, $id,"add_to_info_field")){
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

    }//if $object_of_action =='objects'
    else if($object_of_action =='back_to_objects'){

    	

			$objectZ = get_api_objects();

	        getTGApi(
				'sendMessage', 
				array(
					'chat_id' => $chat_id_in,
					'text' =>'Действующие объекты',
					'disable_web_page_preview' =>false,
					 
	                'reply_markup' => json_encode(array('inline_keyboard' => $objectZ))
				)
			);

    }
    else{
    	
    }

}









?>

