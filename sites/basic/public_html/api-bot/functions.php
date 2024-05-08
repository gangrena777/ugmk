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
	
		$dest = $_SERVER['DOCUMENT_ROOT']. '/web/upload/'.$dir."/". $file_name;


		if(copy($src, $dest)){
			return $file_name;
		} 

}
function getTGApiAudio($options){
	$src  = 'https://api.telegram.org/file/bot' . Token . '/' .$options;

	$file_name = time() . '-' . basename($src);
		$dest = $_SERVER['DOCUMENT_ROOT']. '/web/upload/audio/' . $file_name;
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



        $query_photo = "SELECT * FROM photos WHERE object_id = $id";

        $res_photo = mysqli_query($connect, $query_photo);
        if($res_photo){
        	while($field_photo = mysqli_fetch_assoc($res_photo)){
        		$data['photo_idsz'][] = $field_photo;
        	}

        	
        }

        $query_doc = "SELECT * FROM documents WHERE doc_object_id = $id";

        $res_doc = mysqli_query($connect, $query_doc);
        if($res_doc){

        	  while ($field_doc = mysqli_fetch_assoc($res_doc)) {
						$data['doc_idsz'][] = $field_doc;
        	  }
		}
		$data['obj'] = $info;
    	
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

/////photos //////

function addphotoDB($connect, $object_id, $photo_path){


	$object_id = trim($object_id);
	$photo = trim($photo_path);
	$name = 'bot_'.$photo;
	$path = 'upload/photos/'.$photo;

	
	$t = "INSERT INTO photos (  name, `path`, object_id ) VALUES ('%s', '%s', '%s')";
	$query = sprintf($t, 
						 mysqli_real_escape_string($connect, $name),
						  mysqli_real_escape_string($connect, $path),
						  mysqli_real_escape_string($connect, $object_id),
					);
	$result = mysqli_query($connect, $query);
	if(!$result)
		die(mysqli_error($connect));
	return true;


}


function addfileDB($connect, $object_id, $file_path){


	$object_id = trim($object_id);
	$file = trim($file_path);
	$name = 'bot_'.$file;
	$path = 'upload/documents/'.$file;

	
	$t = "INSERT INTO documents (  doc_name, `doc_path`, doc_object_id ) VALUES ('%s', '%s', '%s')";
	$query = sprintf($t, 
						 mysqli_real_escape_string($connect, $name),
						  mysqli_real_escape_string($connect, $path),
						  mysqli_real_escape_string($connect, $object_id),
					);
	$result = mysqli_query($connect, $query);
	if(!$result)
		die(mysqli_error($connect));
	return true;


}







