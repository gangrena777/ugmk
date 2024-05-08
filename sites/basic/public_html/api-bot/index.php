<?php

//https://api.telegram.org/bot6520239724:AAGd2ef-NZUKWYr2zfJbDHxlbGiaabKKSPM/setWebhook?url=https://cr45681.tmweb.ru/api-bot/index.php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require_once 'constant.php';
require_once 'functions.php';
require_once 'settings.php';

require_once 'assambl.php';


require $_SERVER['DOCUMENT_ROOT']. '/vendor/autoload.php';


use GuzzleHttp\Client;





$data = file_get_contents('php://input');

$data = json_decode($data, true);


//file_put_contents(__DIR__ . '/main_data.txt', print_r($data, true));



file_put_contents(__DIR__ . '/dooc_root.txt', print_r($_SERVER['DOCUMENT_ROOT'], true));



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

     $document = $data['message']['document'];



 

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

	       // if($message !=='' || ( $photo && !empty($photo)) ){


  
		      	if( $user_data = get_user_qwestion_type($connect, $chat_id, $update_id) ){

		      		    //file_put_contents(__DIR__ . '/messageGUQT.txt', print_r($user_data, true));

  						 // если это был вопрос
			      	 	if($user_data['qwestion_data'] !== 0 ){
			                    switch($user_data['qwestion_data']){
			                           case 'add_to_info_field':
			                               //добавить данные в поле info


	                                      $info = get_object_field($connect, 'object', 'info',$user_data['object_id']);
	                                               //если в ответ на прислали фото

	                                            ////доработать если несколько фото
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
																
															
														 
																if ($path = getTGApiFile('photos',$res['result']['file_path'], false)) {

                                                                    $add_photo = addphotoDB($connect,$user_data['object_id'], $path );
                                                                    if($add_photo){

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
											    }///////////////////////////////
                                                  //если  в ответ голосовое сообщение
										        else if($voice  && !empty($voice)){

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


											                                $fileUrl = $_SERVER['DOCUMENT_ROOT'].'/web/upload/audio/'.$path;

											                                $new_path = preg_replace('"\.oga$"', '.mp3', $path); 

											                                // $new_path2 = preg_replace('"\.oga$"', '.ogg', $path); 
																			$newfileUrl = $_SERVER['DOCUMENT_ROOT']. '/web/upload/audio/'.$new_path;
																			//file_put_contents(__DIR__ . '/old_path.txt', print_r($path, true));
										                                    //file_put_contents(__DIR__ . '/new_path.txt', print_r($new_path2, true));
										                                    // Конвертируем аудио в подходящий формат
											
																		     $cmd = "ffmpeg  -i $fileUrl  $newfileUrl";

																		    //file_put_contents(__DIR__ . '/cmd.txt', print_r($cmd, true));
																			$ttt = exec($cmd);
																			// file_put_contents(__DIR__ . '/ttt.txt', print_r($ttt, true));

											                                $fileUrl2 = "https://cr45681.tmweb.ru/web/upload/audio/$new_path";

											                                //////assembly   speech to text ////////////////////////////////

											                                // Upload a file and create a transcript using the AssemblyAI API
																			try {
																			    // Your API token is already set in this variable
																			    $api_token = "f379d6e5d5814df599cafc048118359a";

																			    // -----------------------------------------------------------------------------
																			    // Update the file path here, pointing to a local audio or video file.
																			    // If you don't have one, download a sample file: https://storage.googleapis.com/aai-web-samples/espn-bears.m4a
																			    // You may also remove the upload step and update the 'audio_url' parameter in the
																			    // 'create_transcript' function to point to a remote audio or video file.
																			    // -----------------------------------------------------------------------------
																			  $audioFileName = $fileUrl2;
																			    $upload_url = upload_file($api_token, $audioFileName);

																			    $transcript = create_transcript($api_token, $upload_url);


																			    //echo $transcript['text'];

																			    //file_put_contents(__DIR__ . '/assembly_result.txt', print_r($transcript['text'], true));
                                                                                

																			    getTGApi(
																			    	
																			        'sendMessage', 
																			        array(
																			               'chat_id' => $data['message']['chat']['id'],
																			               'text' => $transcript['text']
																			        
																			        )
																			    );

																			    $mess = $info['info']."\r\n".$transcript['text']; 

																			} catch (Exception $e) {
																			    echo 'Error: ' . $e->getMessage();
																			}


											                                //////###assembly   speech to text ////////////////////////////////
																}

											    }///////////////////////////////
											    else if($document  && !empty($document)){

											       file_put_contents(__DIR__ . '/doc.txt', print_r($document, true));

											        	
														$res = sendTelegram(
															'getFile', 
															array(
																'file_id' => $document['file_id']
															)
														);

													    $res = json_decode($res, true);
															if ($res['ok']) {
																
															
														 
																if ($path = getTGApiFile('documents',$res['result']['file_path'], $document['file_name'])) {

																		//$doc_ids = get_object_field($connect, 'object', 'doc_ids',$user_data['object_id']);

																	    //$add_doc_id = $doc_ids['doc_ids'].",".$path;

																	$add_file = addfileDB($connect,$user_data['object_id'], $path );
                                                                    if($add_file){

                                                                    			sendTelegram(
																					'sendMessage', 
																						array(
																						'chat_id' => $data['message']['chat']['id'],
																						'text' => 'Файл сохранен'
																						)
																				);	
                                                                    
                                                                    }


																}

																$mess = $info['info']."\r\n"."документ_".$path;
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
								                    		    ////отправляем все фото по обьекту
								                    			if( isset($obj['photo_idsz']) && !empty($obj['photo_idsz'])){

								                    			    foreach ($obj['photo_idsz'] as $id => $value) {


								                    					$url_photo = $_SERVER['DOCUMENT_ROOT'].'/web/'.$value['path']; 

								                    					  file_put_contents(__DIR__ . '/pathyyyyy', print_r($url_photo, true));

                                                                        $caption = "картинка_".$value['name'];




                                                                        sendTelegram(
																			'sendPhoto', 
																				array(
																					 	'chat_id' => $data['message']['chat']['id'],
																	                    'photo' => curl_file_create($url_photo), 
																	                    'caption' => $caption, 
																	                    'parse_mode' => "html"
																				)
																		);	
								                    			    }
								                    		    }

								                    		    ////отправляем все документы по обьекту
								                    			if( isset($obj['doc_idsz']) && !empty($obj['doc_idsz'])){

								                    			    	
								                     			    	foreach ($obj['doc_idsz'] as $id => $value) {


								                    						$url_doc = $_SERVER['DOCUMENT_ROOT'].'/web/'.$value['doc_path']; 
																			$caption = "файл_".$value['doc_name'];
																			file_put_contents(__DIR__ . 'urllllfile', print_r($url_doc, true));

																			sendTelegram(
																			    'sendDocument', 
																				    array(
																					 	'chat_id' => $data['message']['chat']['id'],
																	                    'document' => curl_file_create($url_doc), 
																	                    'caption' => $caption, 
																	                   // 'parse_mode' => "html"
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

	       // }
	   
	
		    break;
    }///switch($message)

}

if($dataZ){

	$data_info = explode("/", $dataZ);
	$object_of_action = $data_info[0];
	$action = $data_info[1];
	$id = $data_info[2];




	   //file_put_contents(__DIR__.'/messageCallbackINFO.txt', print_r($data_info, true));
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
                                    ///fotos
									if( isset($obj['photo_idsz']) && $obj['photo_idsz'] !=='' ){

										    //file_put_contents($obj['photos'], data);

										  // file_put_contents(__DIR__ . '/photosz.txt', print_r($obj['photo_idsz'], true));

								                    			
													foreach ($obj['photo_idsz'] as $id => $value) {


								        				$url = $_SERVER['DOCUMENT_ROOT'] .'/web/'.$value['path']; 

								        					file_put_contents(__DIR__ . '/path', 							print_r($url, true));

               											$caption = "КАРТИНКА_".$value['name'];

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
								    ///docs
								    
								    if( isset($obj['doc_idsz']) && $obj['doc_idsz'] !=='' ){

			                    			file_put_contents(__DIR__ . '/path_doc', print_r($obj['doc_idsz'], true));
											foreach ($obj['doc_idsz'] as $id => $value) {


			                    					$url = $_SERVER['DOCUMENT_ROOT'].'/web/'.$value['doc_path']; 

			                    					

                                                    

                                                    sendTelegram(
														'sendDocument', 
															array(
																 	'chat_id' => $chat_id_in,
												                    'document' => curl_file_create($url), 
												                    'caption' => $value['doc_name']
												                   
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
															
															'text' =>"Добавить данные к объекту с  id=".$id."? ",
															
														)
											);
		                            }
		                }
		                break;



				
				default:
						//file_put_contents(__DIR__ . '/messageCallbackDefault.txt', print_r($data, true));
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

