<?php

/** @var yii\web\View $this */

use yii\helpers\Html;


$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        This is the About page. You may modify the following file to customize its content:
    </p>

    <code><?= __FILE__ ?></code>

    <?= Yii::getAlias('@appp'); ?>
<?


// $report = file_get_contents('http://46.160.151.67/intraservice_procs2.php?procedure=get_taskexpenses777&params=date_between&from=20240301&to=20240331&arr=true');




// $lines = explode(PHP_EOL,  $report);
// $array = array();

// foreach ($lines as $line) {
//     if($line){

//        $line2 = preg_split('/\"/',$line);
//        //  $arr = array();
//        //  $arr['Исполнитель'] = $line2[7];
    
//        // $arr['Дата трудозатрат'] =  $line2[5];
//        // $arr['Комментарий'] = isset($line2[9])  ?  $line2[9] : "CCCCCCCCCC";
//        // $arr['Код сервиса'] = isset($line2[21]) ? $line2[21]  : "KKKKKKKKK";
//        // $arr['№ заявки'] = $line2[1];
//        // $arr['Наименование заявки'] = $line2[13];
//        // $arr['Заявитель'] = $line2[19];
//        // $arr['Индефикатор сервиса'] = $line2[15];
//        // $arr['Трудозатраты(мин)'] = isset($line2[11]) ? $line2[11] : 0 ;
//        // $arr['Трудозатраты(часы)'] = isset($line2[11]) ? date( "G:i", mktime( 0, intval($line2[11]))) :  0 ;
//        // $arr['ЧЧ'] = isset($line2[11]) ? round(floatval($line2[11])/60 , 2) : 0 ;;

//        // $array[] = $arr;
//        $array[] = $line2;
      

//     }

// }
// //array_shift($array);
// echo "<pre>";
// print_r($array);
// echo "</pre>";





?>
<?



//  use Shuchkin\SimpleXLSX;

// // Путь к папке с файлами
// $folder_path =  __DIR__.'/TaskToJUNE_1';
// //echo $folder_path;
// // Получаем список файлов в папке
// $file_list = scandir($folder_path);

// $AllTask = array();

// // Проходимся по каждому файлу в папке
// foreach ($file_list as $file) {


//     // Пропускаем файлы . и ..
//     if ($file === '.' || $file === '..') {
//         continue;
//     }
//     $file_path = $folder_path .'/'. $file;
//     echo $file_path;



//     // Проверяем, что файл с расширением .xlsx
//     if (pathinfo($file_path, PATHINFO_EXTENSION) === 'xlsx') {


//         if ( $xlsx = SimpleXLSX::parse($file_path)) {
//             // Produce array keys from the array values of 1st array element
//             $header_values = $rows = [];
//             foreach ( $xlsx->rows() as $k => $r ) {
//                 if ( $k === 0 ) {
//                     $header_values = $r;
//                     continue;
//                 }
//                 //$rows[] = array_combine( $header_values, $r );
//                  $AllTask[] = array_combine( $header_values, $r );
//             }
            
          
//         }
           
//     }

// }

//     echo "<pre>";
//     print_r( $AllTask );
//     echo "</pre>";

          // // Создаем новый файл Excel и сохраняем в него данные
          // $combinedFilePath = '/path/to/combined/file.xlsx';
          // $writer = IOFactory::createWriter($combinedWorkbook, 'Xlsx');
          // $writer->save($combinedFilePath);

          // echo "Файл объединен успешно: $combinedFilePath";

          //$filename = __DIR__.'/TaskSUTO_JUNE1.xlsx';

           //use Shuchkin\SimpleXLSX;

          // // if ( $xlsx = SimpleXLSX::parse($filename) ) {
          // //     echo "<pre>";
          // //    // print_r( $xlsx->rows() );
          // //       print_r( $xlsx->rows() );
          // //     echo "</pre>";
          // // } else {
          // //     echo SimpleXLSX::parseError();
          // // }




          // if ( $xlsx = SimpleXLSX::parse($filename)) {
          //     // Produce array keys from the array values of 1st array element
          //     $header_values = $rows = [];
          //     foreach ( $xlsx->rows() as $k => $r ) {
          //         if ( $k === 0 ) {
          //             $header_values = $r;
          //             continue;
          //         }
          //         $rows[] = array_combine( $header_values, $r );
          //     }
          //     echo "<pre>";
          //     print_r( $rows );
          //     echo "</pre>";
          // }

?>
<!-- 
 <form action="process.php" method="post">
        <label for="folder_path">Enter the folder path:</label>
        <input type="file" name="folder_path[]" id="folder_path"   multiple webkitdirectory directory required>
        <input type="submit" value="Process Files">
    </form> -->
<?
// use Shuchkin\SimpleXLSX;

// $folder_path = __DIR__.'/TaskToJUNE_1';
// $file_list = scandir($folder_path);
// $all_tasks = [];

// foreach ($file_list as $file) {
//     if ($file === '.' || $file === '..') {
//         continue;
//     }
//     $file_path = $folder_path .'/'. $file;

//     // Проверяем, что файл с расширением .xlsx
//     if (pathinfo($file_path, PATHINFO_EXTENSION) === 'xlsx') {
//         // Проверяем, что класс SimpleXLSX существует
//         if (class_exists('Shuchkin\SimpleXLSX')) {
//             // Пытаемся загрузить файл
//             try {
//                 $xlsx = new SimpleXLSX($file_path);
//                 $rows = $xlsx->rows(); // Получаем данные из файла
//                 // Пропускаем первую строку с заголовками
//                 $header_values = array_shift($rows);
//                 // Создаем ассоциативный массив данных
//                 foreach ($rows as $row) {
//                     $all_tasks[] = array_combine($header_values, $row);
//                 }
//             } catch (Exception $e) {
//                 echo 'Ошибка при чтении файла ' . $file . ': ' . $e->getMessage() . "\n";
//             }
//         } else {
//             echo 'Класс SimpleXLSX не найден' . "\n";
//         }
//     }
// }

// echo "<pre>";
// print_r($all_tasks);
// echo "</pre>";




// use GuzzleHttp\Client;
// use GuzzleHttp\Exception\RequestException;
// use GuzzleHttp\Psr7;
// use GuzzleHttp\Promise;
// use Psr\Http\Message\ResponseInterface;

// function createTask(Client $client, $task) {
//     try {
//         $response = $client->post('https://intraservice.ugmk-telecom.ru/api/task', [
//             'json' => $task,
//             'headers' => [
//                 'Authorization' => 'Basic Z2FhMTpnYWExMDcxMQ=='
//             ]
//         ]);

//         return json_decode($response->getBody(), true);
//     } catch (RequestException $e) {
//         echo "Ошибка при создании задачи: " . Psr7\Message::toString($e->getRequest());
//         if ($e->hasResponse()) {
//             echo Psr7\Message::toString($e->getResponse());
//         }
//         return null;
//     }
// }

// function updateTask(Client $client, $taskId, $data) {
//     try {
//         $response = $client->put("https://intraservice.ugmk-telecom.ru/api/task/{$taskId}", [
//             'json' => $data,
//             'headers' => [
//                 'Authorization' => 'Basic Z2FhMTpnYWExMDcxMQ=='
//             ]
//         ]);

//         return json_decode($response->getBody(), true);
//     } catch (RequestException $e) {
//         echo "Ошибка при обновлении задачи: " . Psr7\Message::toString($e->getRequest());
//         if ($e->hasResponse()) {
//             echo Psr7\Message::toString($e->getResponse());
//         }
//         return null;
//     }
// }

// function makeIntraserviceRequest($task) {
//     $client = new Client();
//     $maxAttempts = 3;
//     $attempt = 0;
//     $delay = 2;

//     while ($attempt < $maxAttempts) {
//         $attempt++;
//         try {
//             $taskData = createTask($client, $task);

//             if (isset($taskData['Task'])) {
//                 $taskId = $taskData['Task']['Id'];
//                 $newData = ['StatusId' => 26];

//                 sleep(1); // Задержка перед обновлением

//                 updateTask($client, $taskId, $newData);
//                 sleep(1.5); // Задержка после обновления

//                 return $taskData;
//             }
//         } catch (Exception $e) {
//             echo "Попытка $attempt не удалась: " . $e->getMessage() . "\n";
//             if ($attempt < $maxAttempts) {
//                 sleep($delay); // Задержка перед повторной попыткой
//             }
//         }
//     }

//     return null;
// }

// // Пример вызова функции
// $taskExample = [
//     // Данные вашей задачи
// ];

// $response = makeIntraserviceRequest($taskExample);

// if ($response) {
//     echo "Заявка успешно создана и обновлена";
// } else {
//     echo "Произошла ошибка при обработке заявки";
// }



///////////////////////////



///////////////////////////////////////////////////////////////////////////////
// use Shuchkin\SimpleXLSX;

// $all_tasks = [];

// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['files'])) {
//     $upload_dir = __DIR__ . '/uploads/';

//     // Проверяем, существует ли директория для загрузки, если нет, создаем ее
//     if (!is_dir($upload_dir)) {
//         mkdir($upload_dir, 0777, true);
//     }

//     foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
//         $file_name = basename($_FILES['files']['name'][$key]);
//         $file_path = $upload_dir . $file_name;

//         // Перемещаем загруженные файлы в директорию uploads
//         if (move_uploaded_file($tmp_name, $file_path)) {
//             // Проверяем, что файл с расширением .xlsx
//             if (pathinfo($file_path, PATHINFO_EXTENSION) === 'xlsx') {
//                 // Проверяем, что класс SimpleXLSX существует
//                 if (class_exists('Shuchkin\SimpleXLSX')) {
//                     // Пытаемся загрузить файл
//                     try {
//                         $xlsx = SimpleXLSX::parse($file_path);
//                         if ($xlsx) {
//                             $rows = $xlsx->rows(); // Получаем данные из файла
//                             // Пропускаем первую строку с заголовками
//                             $header_values = array_shift($rows);
//                             // Создаем ассоциативный массив данных
//                             foreach ($rows as $row) {
//                                 $all_tasks[] = array_combine($header_values, $row);
//                             }
//                         } else {
//                             echo 'Ошибка парсинга файла: ' . SimpleXLSX::parseError() . "<br>";
//                         }
//                     } catch (Exception $e) {
//                         echo 'Ошибка при чтении файла ' . $file_name . ': ' . $e->getMessage() . "<br>";
//                     }
//                 } else {
//                     echo 'Класс SimpleXLSX не найден' . "<br>";
//                 }
//             }
//         } else {
//             echo 'Ошибка при загрузке файла ' . $file_name . "<br>";
//         }
//     }
// }

// echo "<pre>";
// print_r($all_tasks);
// echo "</pre>";
//////////////////////////////////////////////////////////////////////////////




 use google\apiclient\src\Google\Client;

// $client = new Google\Client();
// $client->setApplicationName('GGG');
// putenv("GOOGLE_APPLICATION_CREDENTIALS=credential.json");

// $client->useApplicationDefaultCredentials();
// $client->addScope(Google_Service_Drive::DRIVE);


// $folderId = "1pKxsaDiATWYtE8pitlMM5rBRkae1YTl_KglOAg0X22s";
// $opt_params = array(
//    'q'=> "'".$folderId."' in parents"

// );

// $service = new Google_Service_Drive($client);


// $results = $service->files->listFiles($opt_params);


//if(count($results->getFiles()) > 0 ){
  //var_dump($results);

//}

                                  // рабочий вариант

                                  //https://docs.google.com/spreadsheets/d/1RbAvIUFJZqdCPfME_5wI-w2fiHXBFFiafe3GxDXIjOY/edit?gid=0#gid=0


                                  // $id = '1RbAvIUFJZqdCPfME_5wI-w2fiHXBFFiafe3GxDXIjOY';
                                  // $gid = '0';
                                  // //$range = 'A12:D12';
                                  // $range ='';
                                   
                                  // $csv = file_get_contents('https://docs.google.com/spreadsheets/d/' . $id . '/export?format=csv&gid=' . $gid);
                                  // $csv = explode("\r\n", $csv);
                                  // $array = array_map('str_getcsv', $csv);
                                   
                                  // echo "<pre>"; 
                                  // print_r($array);
                                  // echo "</pre>";




  /**
 * Подключаемся к API
 *******************************************************/


// Путь к файлу ключа сервисного аккаунта



// Документация https://developers.google.com/sheets/api/
$client = new Google_Client();
$client->useApplicationDefaultCredentials();
 putenv("GOOGLE_APPLICATION_CREDENTIALS=credential.json");
// Области, к которым будет доступ
// https://developers.google.com/identity/protocols/googlescopes
$client->addScope( 'https://www.googleapis.com/auth/spreadsheets' );

$service = new Google_Service_Sheets( $client );

// ID таблицы
$id_sheets = '1RbAvIUFJZqdCPfME_5wI-w2fiHXBFFiafe3GxDXIjOY';
$response = $service->spreadsheets->get($id_sheets);

$spreadsheetProperties = $response->getProperties();
$spreadsheetProperties->title; // Название таблицы


// foreach ($response->getSheets() as $sheet) {
 
//   // Свойства листа
//   $sheetProperties = $sheet->getProperties();
//  echo  $sheetProperties->title; // Название листа
//  echo "</br>";
 
//   $gridProperties = $sheetProperties->getGridProperties();
//   echo $gridProperties->columnCount; // Количество колонок
//    echo "</br>";
//   echo $gridProperties->rowCount; // Количество строк
 
// }


// echo "<pre>";
// print_r($spreadsheetProperties->title);
// echo "</pre>";

$range = 'Лист1';
$response2 = $service->spreadsheets_values->get($id_sheets,$range);
$response2 = json_decode(json_encode($response2,true),true);;

$header = array_shift($response2['values']);
echo count($header);

$all_tasks = array();
// Создаем ассоциативный массив данных
foreach ($response2['values'] as $row) {

   //echo count($row);
   //echo "<br>";
   $arr_eq = array_pad($row, count($header), " ");
   $all_tasks[] = array_combine($header, $arr_eq);
}

echo "<pre>";
print_r($all_tasks);
echo "</pre>";
?>
</div>
