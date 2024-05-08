<?
function printer($str){

	echo "<pre>";
	print_r($str);
	echo "</pre>";
}


function getTGApi($method, $options = null){


 	$srt_req = API_URL.Token.'/'.$method;

 	if($options){
 		$srt_req .= '?'.http_build_query($options);
 	}

 	$req = file_get_contents($srt_req);


 	return json_decode($req, 1);
}




  function sendTelegram($method, $response)
{
	$ch = curl_init('https://api.telegram.org/bot' . Token . '/' . $method);  
	curl_setopt($ch, CURLOPT_POST, 1);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$res = curl_exec($ch);
	curl_close($ch);
 
	return $res;
}

function getTGApiFile($dir,$options, $filename){
	$src  = 'https://api.telegram.org/file/bot' . Token . '/' .$options;

    if($filename && !$filename ==''){
    	$file_name = $filename;
    }else{
    	$file_name = time() . '-' . basename($src);
    }
	
		$dest = __DIR__ . '/assets/'.$dir."/". $file_name;
		if(copy($src, $dest)){
			return $file_name;
		} 

}

function getTGApiAudio($options){
	$src  = 'https://api.telegram.org/file/bot' . Token . '/' .$options;

	$file_name = time() . '-' . basename($src);
		$dest = __DIR__ . '/assets/audio/' . $file_name;
		if(copy($src, $dest)){
			return $file_name;
		} 

		
		
}


// function setHook($set = 1){
//  	$url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

//  	printer(
//  		  getTGApi('setWebhook', 

//  			array(
//  					'url' => $set ? $url : '',
					
// 				)
//           );
//     );

//          exit();


//  }	

// setHook();

function writeLogFile($str, $clear = false){
 	$log_file_name = __DIR__."/logFile.txt";
 	$now = date("Y-m-d  H:i:s" );
    
    if($clear == false){
 		file_put_contents($log_file_name, $now." ".print_r($str, true)."\r\n", FILE_APPEND );
 	}
 	else{
 		file_put_contents($log_file_name," ");
 		file_put_contents($log_file_name, $now." ".print_r($str, true)."\r\n", FILE_APPEND );
 	}
}


function add_to_info($connect, $user_id, $chat_id, $message_id, $update_id, $object_id,  $qwestion_data )
{
	
	$chat_id = trim($chat_id);
	$message_id = trim($message_id);
	$update_id = trim($update_id);
	$object_id = trim($object_id);
	$qwestion_data = trim($qwestion_data);

	//if($chat_id == $old_id)
	//	return false;
	$t = "INSERT INTO telegrambot (user_id, chat_id, message_id, update_id,object_id, qwestion_data) VALUES ('%s', '%s', '%s', '%s', '%s','%s')";
	$query = sprintf($t, mysqli_real_escape_string($connect, $user_id),
						mysqli_real_escape_string($connect, $chat_id),
						mysqli_real_escape_string($connect, $message_id),
						mysqli_real_escape_string($connect, $update_id),
						mysqli_real_escape_string($connect, $object_id),
						
						mysqli_real_escape_string($connect, $qwestion_data));
	$result = mysqli_query($connect, $query);
	if(!$result)
		die(mysqli_error($connect));
	return true;
}

function get_user_qwestion_type($connect, $chat_id, $update_id){
	$update_need_id = $update_id - 1;
	$query = sprintf("SELECT * FROM telegrambot WHERE chat_id=%d AND update_id=%d", (int)$chat_id, (int)$update_need_id );
	$result = mysqli_query($connect, $query);
	if(!$result)
		die(mysqli_error($connect));
	$get_user = mysqli_fetch_assoc($result);
	return $get_user;

}

function reset_qwestionData($connect, $user_id,  $update_id){

	$user_id = trim($user_id);
	$update_id = trim($update_id -1 );
	

	//if($chat_id == $old_id)
	//	return false;
	$query = "UPDATE  telegrambot SET qwestion_data = 0 WHERE user_id = $user_id AND update_id = $update_id";
	///* AND message_id=$message_id   AND update_id = $update_id*/
	
	$result = mysqli_query($connect, $query);
	if(!$result)
		die(mysqli_error($connect));
	return true;


}

function get_object_field($connect, $table_name, $field, $object_id){
	$query = "SELECT $field  FROM $table_name WHERE id =  $object_id";

	$result = mysqli_query($connect, $query);
	if(!$result)
		die(mysqli_error($connect));
	$field = mysqli_fetch_assoc($result);
	return $field;
}

function update_object_field($connect, $table_name, $field, $data, $object_id){


    
	$query = "UPDATE $table_name  SET $field = '$data' WHERE id = $object_id";
	$result = mysqli_query($connect, $query);
	//if(!$result)
	//	die(mysqli_error($connect));
	return $result;

}

function get_object_by_id($connect, $id){

	$query = "SELECT *  FROM object WHERE id =  $id";

	$result = mysqli_query($connect, $query);
	if(!$result)
		die(mysqli_error($connect));
	$field = mysqli_fetch_assoc($result);

	    $data = [];

	     $info = "ОБЪЕКТ : ".PHP_EOL;
			 $info .= "НАЗВАНИЕ :".$field['name'].PHP_EOL;
			 $info .= "Адресс :".$field['addres'].PHP_EOL;
			 $info .= "Контакты :".$field['communications'].PHP_EOL;
			 $info .= "Описание :".$field['description'].PHP_EOL;
			 $info .= "Данные :".$field['info'].PHP_EOL;
			 // $info .= "Картинки :".$field['photo_ids'].PHP_EOL;

			 $data['obj'] = $info;
			 $data['photo_ids'] = $field['photo_ids'];

			  $data['doc_ids'] = $field['doc_ids'];

             /*    
			 	$buttons_action = [];

	                $buttons_action[] = [['text'=>"Изменить",'callback_data'=>"objects/update/".$field["id"] ]];
					$buttons_action[] = [['text'=>"Удалить",'callback_data'=>"objects/delete/".$field["id"] ]];
					$buttons_action[] = [['text'=>"Добавить информацию",'callback_data'=>"objects/addinfo/".$field["id"] ]];
					$buttons_action[] = [['text'=>"Назад <--",'callback_data'=>"back_to_objects" ]];
			      
			          $data['buttons'] = $buttons_action;	
			          */
			    	
	return $data;

}

function get_object_buttons_by_id($connect, $id){


                 
			 	$buttons_action = [];

	                $buttons_action[] = [['text'=>"Изменить",'callback_data'=>"objects/update/".$id ]];
					$buttons_action[] = [['text'=>"Удалить",'callback_data'=>"objects/delete/".$id ]];
					$buttons_action[] = [['text'=>"Добавить информацию",'callback_data'=>"objects/addinfo/".$id ]];
					$buttons_action[] = [['text'=>"Назад <--",'callback_data'=>"back_to_objects" ]];
			      
			          $data['buttons'] = $buttons_action;	
			    	
	return $data;

}

function get_api_objects(){
	   $objects = file_get_contents('https://cr45681.tmweb.ru/api/objects');
        $data_obj = json_decode($objects, true);

	        uasort($data_obj, function($a, $b){

	          return $b['name'] <=> $a['name'];
	        });
	        $objectZ = [];

			foreach ($data_obj as $key => $value) {

	           $objectZ[] = [['text'=>$value['name'],'callback_data'=>"objects/get/".$value["id"] ]];
	       	}
	       	return $objectZ;

}

function  delete_obj_by_id($connect,$id){

   $query = "DELETE  FROM object WHERE id =  $id";

	$result = mysqli_query($connect, $query);
	if(!$result)
	 die(mysqli_error($connect));
	return true;
}


