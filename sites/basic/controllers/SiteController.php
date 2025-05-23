<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Country;

use app\models\Region;
use app\models\Dogovor;
use app\models\Services;

use app\models\Tasks;



use yii\data\Pagination;

use Shuchkin\SimpleXLSX;
use yii\web\UploadedFile;


// use mikemadisonweb\rabbitmq\components\ConsumerInterface;
// use mikemadisonweb\rabbitmq\components\Producer;
// use mikemadisonweb\rabbitmq\Configuration;



use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use GuzzleHttp\Promise;
use Psr\Http\Message\ResponseInterface;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
              'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['login', 'logout', 'signup','about', 'report','planetask','planerenttask','maketask','taketask','checkto'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['login', 'signup'],
                            'roles' => ['?'],
                        ],
                        [
                          'allow' => true,
                          'actions' => ['logout'],
                           'roles' => ['@'],
                        ],
                    
                        [
                          'allow' => true,
                          'actions' => ['about', 'report', 'maketask','planetask','planerenttask','taketask','checkto'],
                           'roles' => ['admin'],
                        ],
                    ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];

      
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
            $res =  file_get_contents("https://docs.google.com/spreadsheets/d/1RbAvIUFJZqdCPfME_5wI-w2fiHXBFFiafe3GxDXIjOY/export");
            $csv = explode("\r\n", $res);
            $array = array_map('str_getcsv', $csv);

             return $this->render('contact',[ 'ppr' => $array]);
              //     // получаем все строки из таблицы "country" и сортируем их по "name"
              //     $countries = Country::find()->orderBy('name')->all();

              //     // получаем строку с первичным ключом "US"
              //     $country_one = Country::findOne('US');

                

               

              // $model = new ContactForm();

            

              // if ($model->load(Yii::$app->request->post())/* && $model->contact(Yii::$app->params['adminEmail'])*/) {
              //     Yii::$app->session->setFlash('contactFormSubmitted');


              //     $producer = \Yii::$app->rabbitmq->getProducer('producer-send-letter');
              //     $msg = json_encode(['name'=>$model->name, 'email'=>$model->email, 'subject'=>$model->subject,'body'=>$model->body]);
              //     $producer->publish($msg, 'exchange-name','send-letter');

              //       // Yii::$app->mailer->compose(['html'=>'@app/mail/view/letter'], compact('session'))
              //       //                   ->setFrom(['golopolosovartem@yandex.ru'=>'supernew_shop.ru'])
              //       //                   ->setTo($orders->email)
              //       //                   ->setSubject('ВАШ заказ')
              //       //                   ->send();

              //     return $this->refresh();
              // }
              // return $this->render('contact'
              // [
                  //'model' => $model,
                 // 'countries' => $countries,
                 // 'country_one' => $country_one
              //]
              // );
    
    }

  
    public function actionAbout()
    {
        
        return $this->render('about');
    }

  
    protected function findRegions(){

      $regions  = Region::find()->all();
      $regs = array();
      foreach ($regions as  $value) {
          $regs[$value->id] = $value->region_name;
      }
      return $regs;
    }

    protected  function getAllServices(){

      $services = Services::find()->select('services.SERV_ID, services.GUID , services.Attribut_dogovor, services.Path, services.NAME')->joinWith('dogovor')->all();
         
      $SERVICES = array();

      $regions = $this->findRegions();
      foreach ($services as $key => $value) {
             $SERVICES[$value['SERV_ID']]['SERV_ID'] = $value->SERV_ID;
                $SERVICES[$value['SERV_ID']]['GUID'] = $value->GUID;
                  $SERVICES[$value['SERV_ID']]['NAME'] = $value->NAME;
                  $SERVICES[$value['SERV_ID']]['Attribut_dogovor'] = $value->Attribut_dogovor;
                    $SERVICES[$value['SERV_ID']]['dogovor']['CODE_NG'] = $value->dogovor->CODE_NG ?? 0;
                      $SERVICES[$value['SERV_ID']]['dogovor']['NAME_NG'] = $value->dogovor->NAME_NG ?? 0;
                        $SERVICES[$value['SERV_ID']]['dogovor']['USE_TMC'] = $value->dogovor->USE_TMC ?? 0;
                          $SERVICES[$value['SERV_ID']]['dogovor']['REGION_ID'] = $value->dogovor->REGION_ID ?? 0;
                             $SERVICES[$value['SERV_ID']]['dogovor']['PLAN'] = $value->dogovor->PLAN ?? 0;
                                 $SERVICES[$value['SERV_ID']]['dogovor']['CODE'] = $value->dogovor->CODE ?? 0;
                                     $SERVICES[$value['SERV_ID']]['dogovor']['CONTRAGENT'] = $value->dogovor->CONTRAGENT ?? 0;
                            $SERVICES[$value['SERV_ID']]['Path'] = $value->Path ?? 'Z';

                            $id = $value->dogovor->REGION_ID ?? 0;
                            if( $id > 0){
                              $SERVICES[$value['SERV_ID']]['dogovor']['REGION_NAME'] = $regions[$value->dogovor->REGION_ID];
                            }else{
                               $SERVICES[$value['SERV_ID']]['dogovor']['REGION_NAME'] = '';
                            }
      }
      return $SERVICES;
    }

    protected function getAllDogovor(){
    }

   
    protected  function Group_by($key, $data) {

         $result = array();

         $Sum =0;

          foreach($data as $val) {
              if(array_key_exists($key, $val)){
                  $result[$val[$key]][] = $val;

              }else{
                  $result[""][] = $val;
              }
          }

          return $result;
    }

    /////////////////////////////

    protected function ArrayGroupBy(array $array, $key)
    {
        if (!is_string($key) && !is_int($key) && !is_float($key) && !is_callable($key) ) {
          trigger_error('array_group_by(): The key should be a string, an integer, or a callback', E_USER_ERROR);
          return null;
        }

        $func = (!is_string($key) && is_callable($key) ? $key : null);
        $_key = $key;

        // Load the new array, splitting by the target key
        $grouped = [];
        foreach ($array as $value) {
          $key = null;

          if (is_callable($func)) {
            $key = call_user_func($func, $value);
          } elseif (is_object($value) && property_exists($value, $_key)) {
            $key = $value->{$_key};
          } elseif (isset($value[$_key])) {
            $key = $value[$_key];
          }

          if ($key === null) {
            continue;
          }

          $grouped[$key][] = $value;
        
        }

        // Recursively build a nested grouping if more parameters are supplied
        // Each grouped array value is grouped according to the next sequential key
        if (func_num_args() > 2) {
          $args = func_get_args();

          foreach ($grouped as $key => $value) {
            $params = array_merge([ $value ], array_slice($args, 2, func_num_args()));
            $grouped[$key] = call_user_func_array(array('self','ArrayGroupBy'),$params);
            //call_user_func_array('self','ArrayGroupBy', $params);
          }
        }

        return $grouped;
    }
    /////////////////////////
    
    protected function get_taskexpenses777($date_from, $date_to,  $status = null){
    	         

                    $data_str = $date_from." --  ".$date_to;

                    $report = file_get_contents('http://46.160.151.67/intraservice_procs2.php?procedure=get_taskexpenses777&params=date_between&from='.$date_from.'&to='.$date_to);

                    $lines = explode(PHP_EOL,  $report);
                    $array = array();


                    $FINALL = array();
                    foreach ($lines as $line) {
                      if($line){

                         $line2 = preg_split('/\"/',$line);
                          $arr = array();
                          $arr['Исполнитель'] = $line2[7];
                      
                         $arr['Дата трудозатрат'] =  $line2[5];
                         $comment = isset($line2[9])  ?   mb_substr(trim($line2[9]),0, 3) : "CCCCCCCCCC";
                         $arr['Комментарий'] = mb_strtolower($comment);
                         $arr['Код сервиса'] = isset($line2[21]) ? $line2[21]  : "KKKKKKKKK";
                         $arr['№ заявки'] = $line2[1];
                         $arr['Наименование заявки'] = $line2[13];
                         $arr['Заявитель'] = $line2[19];
                         $arr['Индефикатор сервиса'] = intval($line2[15]);
                         $arr['Трудозатраты(мин)'] = isset($line2[11]) ? $line2[11] : 0 ;
                         $arr['Трудозатраты(часы)'] = isset($line2[11]) ? date( "G:i", mktime( 0, intval($line2[11]))) :  0 ;
                         $arr['ЧЧ'] = isset($line2[11]) ? round(floatval($line2[11])/60 , 2) : 0 ;
                         $arr['Статус'] = $line2[23];
                         $arr['Тип'] = $line2[3];

                         $array[] = $arr;
                        //$array[] = $line2;
                        

                      }

                    }

                    $services = $this->getAllServices();
                    array_shift($array);
                    $NewArr =[];
                    foreach ($array as $key => $val) {

                      	if(isset($status)  && !empty($status)){

                      		if( in_array($val['Статус'] , $status)){
                      	
                      				    //  if($val['Статус'] == '28' || $val['Статус'] == '29' ||  $val['Статус'] == '27' || $val['Статус'] == '26' ){
                      	                    	  
                      	
  				                        if($val['Индефикатор сервиса'] > 0 ){
  				                              if(array_key_exists($val['Индефикатор сервиса'], $services )){
  				                            
  				                                  $val['Attribut_dogovor'] = $services[$val['Индефикатор сервиса']]['Attribut_dogovor'];
  				                                  $val['dogovor_name'] = $services[$val['Индефикатор сервиса']]['NAME'];
  	
  	
  				                                  $val['Код НГ'] = $services[$val['Индефикатор сервиса']]['dogovor']['CODE_NG'];
  				                                  $val['Название НГ'] = $services[$val['Индефикатор сервиса']]['dogovor']['NAME_NG'];
  				                                  $val['Назначение ТМЦ'] = $services[$val['Индефикатор сервиса']]['dogovor']['USE_TMC'];
  				                                  $val['Д.Code'] = $services[$val['Индефикатор сервиса']]['dogovor']['CODE'];
  				                                  $val['Д.Contragent'] = $services[$val['Индефикатор сервиса']]['dogovor']['CONTRAGENT'];
  				                                  $val['Д.Plan'] = $services[$val['Индефикатор сервиса']]['dogovor']['PLAN'];
  	
  				                                  $val['Участок'] = $services[$val['Индефикатор сервиса']]['dogovor']['REGION_NAME'];
  				                                      ///////
  				                                     $start_path = explode("|", $services[$val['Индефикатор сервиса']]['Path']);
  				                                       if(isset($services[$start_path[0]])) {
  				                                  $val['Участок__'] = $services[$start_path[0]]['NAME'];
  	
  	
  				                                       }else{
  				                                        $val['Участок__'] = 'ZZZZ';
  				                                       }
  				                                 
  				                              }
  	
  				                        }else{
  	
  				                                $val['Attribut_dogovor'] = 0;
  				                                $val['Код НГ'] = 0;
  				                                $val['Название НГ'] = '_';
  				                                $val['Назначение ТМЦ'] = '_';
  				                                $val['Участок'] = '_';
  				                                $val['Участок__'] = '_';
  				                        }
  	
  				                       
  				                        $NewArr[] = $val;
                      				                    
                      				                    
                      	    }
                        }else{

      			                if($val['Индефикатор сервиса'] > 0 ){
      			                              if(array_key_exists($val['Индефикатор сервиса'], $services )){
      			                            
      			                                  $val['Attribut_dogovor'] = $services[$val['Индефикатор сервиса']]['Attribut_dogovor'];
      			                                  $val['dogovor_name'] = $services[$val['Индефикатор сервиса']]['NAME'];


      			                                  $val['Код НГ'] = $services[$val['Индефикатор сервиса']]['dogovor']['CODE_NG'];
      			                                  $val['Название НГ'] = $services[$val['Индефикатор сервиса']]['dogovor']['NAME_NG'];
      			                                  $val['Назначение ТМЦ'] = $services[$val['Индефикатор сервиса']]['dogovor']['USE_TMC'];
      			                                  $val['Д.Code'] = $services[$val['Индефикатор сервиса']]['dogovor']['CODE'];
      			                                  $val['Д.Contragent'] = $services[$val['Индефикатор сервиса']]['dogovor']['CONTRAGENT'];
      			                                  $val['Д.Plan'] = $services[$val['Индефикатор сервиса']]['dogovor']['PLAN'];

      			                                  $val['Участок'] = $services[$val['Индефикатор сервиса']]['dogovor']['REGION_NAME'];
      			                                      ///////
      			                                     $start_path = explode("|", $services[$val['Индефикатор сервиса']]['Path']);
      			                                      // if(isset($services[$start_path[0]])) {
      			                                  $val['Участок__'] = $services[$start_path[0]]['NAME'];


      			                                       //}else{
      			                                       //  $val['Участок__'] = 'ZZZZ';
      			                                       //}
      			                                 
      			                              }

      			                }else{

      			                                $val['Attribut_dogovor'] = 0;
      			                                $val['Код НГ'] = 0;
      			                                $val['Название НГ'] = '_';
      			                                $val['Назначение ТМЦ'] = '_';
      			                                $val['Участок'] = '_';
      			                                $val['Участок__'] = '_';
      			                }

  			                    $NewArr[] = $val;
  			                      
  			                }   
			        } 

                   return $NewArr;
			        
    }

    public function actionReport()
    {
          $req = Yii::$app->request;
          if(  $req->get('date_from')  && $req->get('date_to') ){


                $from = str_replace('-', '', $req->get('date_from'));
                $to = str_replace('-', '', $req->get('date_to'));

                $data_str = $req->get('date_from')." --  ".$req->get('date_to');

          	  
	                 /////////////  end TOTAL   ///////////////////////////
				                 //////////////////////////////////////////IF TASKS  /////////////////////////

	                if(  $req->get('report')  &&  $req->get('report') == 1){

                        $NewArr = $this->get_taskexpenses777($from, $to, [27,28,29]);
	                 
	                       $TASKS = $this->ArrayGroupBy($NewArr, 'Участок__', 'Тип','№ заявки');


	                      return $this->render('report_t',[

	                        
	                           
	                          'array' => $NewArr,
	                           
	                          'array3' => $TASKS,
	                         
	                        
	                          'data_str' => $data_str
	                      ]);


	                }
	                //////////////////////////////  end IF TASK   ///////////////////////////////

	                else{

	                	    $NewArr = $this->get_taskexpenses777($from, $to, [27,28,29]);

                            if($NewArr){

				                        ////  TOTAL  ////////////////////////////////////////
				                        $NewArr2 = $this->Group_by('Исполнитель', $NewArr);
				                
				                         $Total = array(); ////------- Всего времени пользователем

				                        foreach ($NewArr2 as $key => $value) {
								                $itemsSum = array_column($value, 'ЧЧ');
				                                $Total[$key] = array_sum($itemsSum); /// Исполнитель => всего времени
				                        }

				                        $NewArr3 = $this->ArrayGroupBy( $NewArr, 'Исполнитель','Название НГ');

				                        foreach ($NewArr3 as $key => $users) {

				                          
				                  
				                            foreach ($users as $ky => $objs) {

				                                $summ = 0;

					                            foreach ($objs as $k => $val) {

					                                $summ += $val['ЧЧ'];

					                            }

					                              $NewArr3[$key][$ky]['OBJ_SUM'] = $summ;
					                              $NewArr3[$key][$ky]['Код НГ'] = $objs[0]['Код НГ'];
					                              $NewArr3[$key][$ky]['Название НГ'] = $objs[0]['Название НГ'];
					                              $NewArr3[$key][$ky]['Назначение ТМЦ'] = $objs[0]['Назначение ТМЦ'];
					                              $NewArr3[$key][$ky]['Участок'] = $objs[0]['Участок'];
					                              $NewArr3[$key][$ky]['Участок__'] = $objs[0]['Участок__'];
					                              
					                              $NewArr3[$key][$ky]['TOTAL'] = $Total[$key];

				                            }
				                          
				                              
				                        }

				                                  // Yii::$app->mailer->compose()
				                                  //  // ->setFrom(Yii::$app->params['senderEmail'])
				                                  // ->setFrom('gaa1@ugmk-telecom.ru')
				                                  //  // ->setTo(Yii::$app->params['gaa1@ugmk-telecom.ru'])
				                                  //   ->setTo('gaa1@ugmk-telecom.ru')
				                                  //   ->setSubject('Заполнена форма обратной связи')
				                                  //   ->setTextBody('TEST')
				                                  //   ->setHtmlBody('<p>TTTTTTTTTTTTTTTTTTTTTTTTTTTTT</p>')
				                                  //   ->send();

				                        return $this->render('report',[
				                           
				                             'array' => $NewArr3,
				                           
				                             'data_str' => $data_str
				                        ]);
	                        }
                          
                    }
          }
          else   return $this->render('report'); 
    }


    public function actionMaketask()
    {
        $all_tasks = [];
        $empty_time = [];
        $folder_name = Yii::$app->request->get('folder', '');

        if (Yii::$app->request->isPost) {
            $uploaded_files = UploadedFile::getInstancesByName('files');
            $all_tasks = $this->getFiles( $uploaded_files);
        }

        $done_tasks = array();
        $fail_tasks = array();
        $message = array();
        foreach ($all_tasks as $key => $value) {
            foreach ($value as $k => $val) {
              if(str_contains($k, 'Field')  && $val > 0 ){
              	$value['Deadline'] = date("d.m.Y", strtotime("last day of this month"));

                    $response = $this->makeIntraserviceRequest($value);

               
                    if( isset($response['failedTasks'])){
                       $fail_tasks[] = $response;
                    }else{
                         $done_tasks[] = $response;
                    }

                      //////test 
                    // $done_tasks[] = $response;

              }
            }
        }
        return $this->render('maketask', [ 'done_tasks' => $done_tasks, 'fail_tasks' => $fail_tasks]);
    }
    
    protected function getFiles($data){

       foreach ($data as $file) {
                // Проверяем, что файл с расширением .xlsx
                if ($file->extension === 'xlsx') {
                    // Проверяем, что класс SimpleXLSX существует
                    if (class_exists('Shuchkin\SimpleXLSX')) {
                        // Пытаемся загрузить файл
                        try {
                            $xlsx = SimpleXLSX::parse($file->tempName);
                            if ($xlsx) {
                                $rows = $xlsx->rows(); // Получаем данные из файла
                                // Пропускаем первую строку с заголовками
                                $header_values = array_shift($rows);
                                // Создаем ассоциативный массив данных
                                foreach ($rows as $row) {

                                   // $all_tasks[] = array_combine($header_values, $row);
                                  yield   array_combine($header_values, $row);
                                }
                            } else {
                                Yii::$app->session->setFlash('error', 'Ошибка парсинга файла: ' . SimpleXLSX::parseError());
                            }
                        } catch (\Exception $e) {
                            Yii::$app->session->setFlash('error', 'Ошибка при чтении файла ' . $file->name . ': ' . $e->getMessage());
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Класс SimpleXLSX не найден');
                    }
                }
            }
    }

    protected  function mergeArrays($array1, $array2) {
          
        $merged = $array2; // Начинаем с массива $array2

		    foreach ($array1 as $outerKey => $innerArray1) {
		        if (!isset($merged[$outerKey])) {
		            $merged[$outerKey] = $innerArray1;
		        } else {
		            foreach ($innerArray1 as $innerKey => $values1) {
		                if (!isset($merged[$outerKey][$innerKey])) {
		                    $merged[$outerKey][$innerKey] = $values1;
		                } else {
		                    // Объединяем вложенные массивы
		                    $merged[$outerKey][$innerKey] = array_merge($merged[$outerKey][$innerKey], $values1);
		                }
		            }
		        }
		    }

		    return $merged;
	  }

    protected function createTask(Client $client, $task) {
        try {
            $response = $client->post('https://intraservice.ugmk-telecom.ru/api/task', [
                'json' => $task,
                'headers' => [
                    'Authorization' => 'Basic Z2FhMTpnYWExMDcxMQ=='
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
           // echo "Ошибка при создании задачи: " . Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
               // echo Psr7\Message::toString($e->getResponse());
            }
            return null;
        }
    }

    protected function updateTask(Client $client, $taskId, $data) {
        try {
            $response = $client->put("https://intraservice.ugmk-telecom.ru/api/task/{$taskId}", [
                'json' => $data,
                'headers' => [
                    'Authorization' => 'Basic Z2FhMTpnYWExMDcxMQ=='
                ]
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            echo "Ошибка при обновлении задачи: " . Psr7\Message::toString($e->getRequest());
            if ($e->hasResponse()) {
                echo Psr7\Message::toString($e->getResponse());
            }
            return null;
        }
    }
    protected function makeIntraserviceRequest($task) {
        $client = new Client();
        $maxAttempts = 2;
        $attempt = 0;
        $delay = 2;
        $failedTasks = [];

        // while ($attempt < $maxAttempts) {
        //     $attempt++;
        
                $taskData = $this->createTask($client, $task);



                if ($taskData &&  isset($taskData['Task'])) {
                    $doneTasks = [];
                    $doneTasks['taskId'] = $taskData['Task']['Id'];
                    $doneTasks['taskName'] = $taskData['Task']['Name'];
                    $doneTasks['taskService'] = $taskData['Task']['ServiceId'];
                    $doneTasks['taskDate_create'] = $taskData['Task']['Created'];
                    $doneTasks['taskServicePath'] = $taskData['Task']['ServicePath'];
                    $doneTasks['taskRegion'] = $task['RegionId'];
                    $doneTasks['taskAgreementID'] = $task['AgreementID'] ?  $task['AgreementID'] : "__";
                     $doneTasks['Deadline'] = $task['Deadline'];

                    ///log  task create
                    \Yii::info("Заявка id:". $taskData['Task']['Id'].", name:".$taskData['Task']['Name'].", service:".$taskData['Task']['ServiceId']."---успешно  создана в INTRASEWRVICE", 'task_create');

                    $TaskAddInDb = new Tasks();
                     $TaskAddInDb->region_id = $task['RegionId'];
                      $TaskAddInDb->task_name = $taskData['Task']['Name'];
                       $TaskAddInDb->dogovor_code = $task['AgreementID'];
                        $TaskAddInDb->task_id = $taskData['Task']['Id'];
                         $TaskAddInDb->date_create = $taskData['Task']['Created'];
                         if($TaskAddInDb->save() ){

                               ///log  task save in db
                               \Yii::info("Заявка id:". $taskData['Task']['Id'].", name:".$taskData['Task']['Name'].", service:".$taskData['Task']['ServiceId']."---успешно добавлена в базу", 'task_create');


                               return ['succes maketask in IS' =>$doneTasks,  'succes save DB' => "Заявка id:". $taskData['Task']['Id']." save in DB"];
                         }else{
                         	   ///log  task save in db
                               \Yii::info("Заявка id:". $taskData['Task']['Id'].", name:".$taskData['Task']['Name'].", service:".$taskData['Task']['ServiceId']."---ошибка при добавлении в базу", 'task_create');
                               return ['succes maketask in IS' =>$doneTasks, 'error' =>'task id='.$taskData['Task']['Id'].' not save in DB'];
                         }
                        
                }
        
                else{
                     \Yii::warning("Заявка  name:".$task['Name'].", serviceId:".$task['ServiceId']."---не создалась в INTRASERVICE ", 'task_create');
                         
                         $failedTasks[] = [
                            'task' => $task,
                            'attempt' => $attempt,
                            'error' => 'Ошибка при создании заявки'
                         ];

                    return ['failedTasks' => $failedTasks];
                }

                // if ($attempt < $maxAttempts) {
                //          sleep($delay); // Задержка перед повторной попыткой
                // }
        //}

        // return ['failedTasks' => $failedTasks];
    }

    public function  actionPlanetask(){

        $all_tasks = [];
        $empty_time = [];
        $folder_name = Yii::$app->request->get('folder', '');

        if (Yii::$app->request->isPost) {
            $uploaded_files = UploadedFile::getInstancesByName('files');
            $all_tasks = $this->getFiles( $uploaded_files);
        }
        $regions = $this->findRegions();
        $done_tasks = array();
       
        ////////////////////////////////////////////




        $services = $this->getAllServices();
      

        foreach ($all_tasks as $key => $value) {

            // $value['RegionName'] = $regions[$value['RegionId']];

            // if(array_key_exists($value['ServiceId'], $services )){

            // 	$value['dogovor_code'] = $services[$value['ServiceId']]['dogovor']['CODE'];
            // 	$value['dogovor_contragent'] = $services[$value['ServiceId']]['dogovor']['CONTRAGENT'];


            // }else{
            // 	$value['dogovor_code'] = "ZZZZZ";
            // }


            foreach ($value as $k => $val) {
              if(str_contains($k, 'Field')  && $val > 0 ){

              	$value['RegionName'] = $regions[$value['RegionId']];

                if(array_key_exists($value['ServiceId'], $services )){

            	    $value['dogovor_code'] = $services[$value['ServiceId']]['dogovor']['CODE'];
            	    $value['dogovor_contragent'] = $services[$value['ServiceId']]['dogovor']['CONTRAGENT'];


                }else{
            	    $value['dogovor_code'] = "ZZZZZ";
                }


                //////test 
                $done_tasks[] = $value;

              }
            }
        }

        $regs = $this->Group_by('RegionName', $done_tasks);

        $DATA = array();
        foreach ($regs as $key => $value) {
        	$SUM =0;
        
        	foreach ($value as $k => $val) {

          $tt = (isset($val['Field1307'])) ? (floatval($val['Field1307'])) : (floatval($val['Field1302']));

        		$SUM += $tt;



        	       
        	
        	}
        	// $regs[$key]['REGION_TT_SUMM'] = $SUM;
        	$DATA[$key]['SUMM'] = $SUM;
        	$DATA[$key]['COUNT'] = count($value);
        }



        return $this->render('planetask', [ 

        	                                 'array' => $done_tasks, 
        	                                 ///'array' => $all_tasks,
        	                                 'regs' => $DATA 
        	                               ]);
    }


    public function actionTaketask(){
               
            $req = Yii::$app->request;
           if(  $req->get('date_from')  && $req->get('date_to') ){


                    $from = str_replace('-', '', $req->get('date_from'));
                    $to = str_replace('-', '', $req->get('date_to'));

                    $data_str = $req->get('date_from')." --  ".$req->get('date_to');


                    $report = file_get_contents('http://46.160.151.67/intraservice_procs2.php?procedure=get_task_from_intraservice777&params=date_between&from='.$from.'&to='.$to);
                 

                    $lines = explode(PHP_EOL,  $report);
                    $array = array();


                    $FINALL = array();
                    foreach ($lines as $line) {
                      if($line){

                         $line2 = preg_split('/\"/',$line);
                           $arr = array();
                           $arr['№ заявки'] = $line2[1];
                             $arr['Тип'] = $line2[3];
                                $arr['Создана'] = $line2[5];
                                    $arr['Заявитель'] = $line2[7];
                                       $arr['Исполнитель'] = $line2[9];
                                         $arr['Наименование заявки'] = $line2[13];
                                          // $arr['Описание заявки'] = $line2[13];
                                              $arr['Статус'] = $line2[15]; 
                                                 $arr['Дата выполнения'] =  $line2[17];
                                                   $arr['Дата изменения статуса'] =  $line2[19];
                                                      $arr['Срок откладывания'] = $line2[21];
                                                        $arr['Причина откладывания'] = $line2[23]; 
                                                          $arr['Норматив трудозатрат'] =  $line2[25];
                                                             $arr['Трудозатраты'] =  $line2[27];
                                                                 $arr['Категория'] =  $line2[29];
                                                                     $arr['Вложение'] = $line2[31];
                                                                         $arr['DayDiff'] =  $line2[33];
                                                                            $arr['serviceId'] = $line2[39];
                                                                                  $array[] = $arr;
                                                                                     //$array[] = $line2;
                        

                      }

                    }

                    $services = $this->getAllServices();
                    array_shift($array);
                    $NewArr =[];
                    foreach ($array as $key => $val) {


                         if($val['serviceId'] > 0 ){
                              if(array_key_exists($val['serviceId'], $services )){
                            
                                  $val['Участок'] = $services[$val['serviceId']]['dogovor']['REGION_NAME'];
                                      ///////
                                  $start_path = explode("|", $services[$val['serviceId']]['Path']);
                                      if(isset($services[$start_path[0]])) {
                                  $val['Участок__'] = $services[$start_path[0]]['NAME'];
                                      }else{
                                         $val['Участок__'] = 'this is test';
                                      }
                                 
                              }

                          }else{

                            
                                $val['Участок'] = '_';
                                $val['Участок__'] = '_';
                          }

                        
                          $NewArr[] = $val;
                        
                    }

                    $DATA2 = array();
                    $TASKS = $this->ArrayGroupBy($NewArr, 'Участок__', 'Тип','Статус');

                          // foreach ($TASKS as $key => $region) {   ////region
                          //         $TOTAL = 0;
                                
                          //         foreach ($region as $k => $type) {   /////type
                          //           $type_count = 0;
                          //           $types = array();
                          //           $status_count = 0;
                                     
                          //               foreach ($type as $i => $task) { ////task status
                                           
                          //                   $status_count = count($task);

                          //                   $type_count += $status_count;
                          //                  // $DATA2[$key][$k][$i] = $status_count;
                                          
                                      
                                           
                          //               }
                          //           $types[$k][$i] = $status_count;
                          //           //$DATA2[$key][$k]['type_count'] =  $type_count;
                          //           // $types[$key][$k][$i]['type_count'] = $type_count;
                          //           $TOTAL += $type_count;
                          //         }
                          //        $DATA2[$key]['TOTAL_COUNT'] = $TOTAL;
                          //        $DATA2[$key]['type'] = $types;
                          // }
                               
                        
                    
                          
                    return $this->render('taketask', [ 'array' => $TASKS, 'data_str' => $data_str,  'array2' => $NewArr]);
                   
            }
            else return $this->render('taketask');
    }

    public function  actionPlanerenttask(){

        $plan_tasks = [];
        $empty_time = [];
        $ERROR = [];

     

        $folder_name = Yii::$app->request->get('folder', '');

        if (Yii::$app->request->isPost) {

            $uploaded_files = UploadedFile::getInstancesByName('files');
            $plan_tasks = $this->getFiles( $uploaded_files);
        }else{
        	$ERROR[] = "Загрузите файл...";

        }

        if(Yii::$app->request->post('date_from') && Yii::$app->request->post('date_to')) {

        	$from = str_replace('-', '', Yii::$app->request->post('date_from'));
            $to = str_replace('-', '', Yii::$app->request->post('date_to'));

            $data_str = $from." --  ".$to;

        }else{
        	$ERROR[] = "Заполните даты периода....";
        }

        if( empty($ERROR)){

						    $regions = $this->findRegions();


						    $done_tasks = array();
						   
						    ////////////////////  PLAN  ////////////////////////

						    $services = $this->getAllServices();
						  

						    foreach ($plan_tasks as $key => $value) {

						   

						        foreach ($value as $k => $val) {
						          if(str_contains($k, 'Field')  && $val > 0 ){

						          	$value['RegionName'] = $regions[$value['RegionId']];

						            if(array_key_exists($value['ServiceId'], $services )){

						        	    $value['dogovor_code'] = $services[$value['ServiceId']]['dogovor']['CODE'];
						        	    $value['dogovor_contragent'] = $services[$value['ServiceId']]['dogovor']['CONTRAGENT'];


						            }else{
						        	    $value['dogovor_code'] = "ZZZZZ";
						        	     $value['dogovor_contragent'] = "YYYYY";
						            }


						            //////test 
						            $done_tasks[] = $value;

						          }
						        }
						    }

						     $plan_tasks = $this->ArrayGroupBy($done_tasks, 'RegionName', 'dogovor_code');

						  

						    $DATA_PLAN = array();
						    foreach ($plan_tasks as $key => $region) {


                                
						    	  foreach ($region as $kk => $contract) {

                        $SUM = 0;
						    		    
                        foreach ($contract as $k => $task) {

                           $tt = (isset($task['Field1307'])) ? (floatval($task['Field1307'])) : (floatval($task['Field1302']));

						    	     	   $SUM += $tt;

						    	     	   $contr = $task['dogovor_contragent'];

						    		
						    		    }

						    	     $DATA_PLAN[$key][$kk]['PLAN_ЧЧ']    = $SUM;
						    	      //$DATA_PLAN[$key][$kk]['CONTRAGENT'] =  $contr;
						        }
						    }
						    //////////////// end  PLAN  //////////////////////////

						    $NewArr = $this->get_taskexpenses777($from, $to, [27,28,29]);

                //$NewArrr = $this->ArrayGroupBy($NewArr,'Участок__', 'Д.Code', 'Комментарий');

                $NewArrrX = $this->ArrayGroupBy($NewArr,'Участок__', 'Д.Code', 'Комментарий','Тип');


                $NewArrrPerson = $this->ArrayGroupBy($NewArr,'Участок__', 'Д.Code', 'Исполнитель','Комментарий','Тип');   ///разбить  по людям


                $DATA_FAKT = array();


			          foreach ($NewArrrX as $key => $Region) {

			                	foreach ($Region as $kk => $Contr) {
			                		  $TOTAL = 0;
			                		  $TASKS =[];
			                		  foreach ($Contr as $k => $comment) {
                                        $COM_TOTAL = 0;

                                            foreach($comment as $kx => $type){
                                                $type_total = 0;

                                            	  foreach ($type as $kz => $task) {

			                			                        $type_total += $task['ЧЧ'];
			                			                        $DATA_FAKT[$key][$kk][$k]['TASKS'][] = $task;
			                			                        $Contragent = $task['Д.Contragent'];
			                			                        $DPlan      = $task['Д.Plan'];

								                                }
								                              $DATA_FAKT[$key][$kk][$k]['TYPE'][$kx] = $type_total;
								                              $COM_TOTAL +=$type_total;
                                            }
			                			       
                                           $DATA_FAKT[$key][$kk][$k]['FAKT_ЧЧ'] = $COM_TOTAL;
                                           $TOTAL += $COM_TOTAL;
                            }
                                    
			                		
			                		$DATA_FAKT[$key][$kk]['FAKT_ЧЧ'] = $TOTAL;

			                		//$DATA_FAKT[$key][$kk]['FAKT_ЧЧ'] = 

			                		$DATA_FAKT[$key][$kk]['Contragent'] = $Contragent;
			                		$DATA_FAKT[$key][$kk]['DPlan'] = $DPlan;
				                }
				        }


				        $mergedArray = $this->mergeArrays($DATA_PLAN, $DATA_FAKT);

                ////////-----PERSON--------////////////////////

                $DATA_FAKT_PERSON = [];
                
                foreach ($NewArrrPerson as $rey => $region) {  //region

                     foreach ($region as $cey => $contract) {  //contract

                         foreach ($contract as $pey => $person) { //person
                           
                           $person_total = 0;

                            foreach ($person as $key => $comment) {  //comment
                               
                               $comment_total = 0;

                                foreach ($comment as $tey => $type) {  // type

                                    $total_type = 0; 

                                    foreach ($type as $k => $task) {  //task
                                     
                                        $total_type += $task['ЧЧ'];
                                        $Contragent = $task['Д.Contragent'];
                                        $DPlan      = $task['Д.Plan'];
                                    }

                                    $DATA_FAKT_PERSON[$rey][$cey][$pey][$key]['TYPES'][$tey] = $total_type;
                                    $comment_total += $total_type;

                                }
                               
                               $DATA_FAKT_PERSON[$rey][$cey][$pey][$key]['COM_ЧЧ'] = $comment_total;
                               $person_total += $comment_total;
 
                            }
                           $DATA_FAKT_PERSON[$rey][$cey][$pey]['PERSON_ЧЧ'] =  $person_total;

                         }
                         
                      $DATA_FAKT_PERSON[$rey][$cey]['Contragent'] = $Contragent ? $Contragent : "_";
                      $DATA_FAKT_PERSON[$rey][$cey]['DPlan'] = $DPlan ? $DPlan : "_";   

                        
                       
                     }
                  
                }

                $mergedArrayPerson = $this->mergeArrays($DATA_PLAN, $DATA_FAKT_PERSON);




                ////////-----PERSON--------////////////////////


				        return $this->render('report_arr', [ 

						    	                                 'data_str' => $data_str,
						    	                                 //'array' => $NewArrrX,
						    	                                 'array' => $mergedArray,
						    	                                 
						    	                                 'array2' => $mergedArray,
                                                   //'arrayP' =>$NewArrrPerson

                                                   //'arrayP' =>$DATA_FAKT_PERSON
                                                   'arrayP' => $mergedArrayPerson
						    	                               ]);

        }else{

			    return $this->render('report_arr', [  'error' => $ERROR ]);
        }
   
    }


    public function actionCheckto(){ 

    	  $regions = $this->findRegions();

    	    $req = Yii::$app->request;
            if(  $req->get('date_from')  && $req->get('date_to') ){


                $from = str_replace('-', '', $req->get('date_from'));
                $to = str_replace('-', '', $req->get('date_to'));

                $data_str = $req->get('date_from')." --  ".$req->get('date_to');

                $current_reg_id = 0;
                $current_reg = '';

                if( $req->get('region') && $req->get('region') !== ''){

                	$current_reg_id = $req->get('region');
                	$current_reg = $regions[$current_reg_id];
                }
                //// вставляем  id фильтра из интры
                if( $current_reg_id !== 0){

			            switch ($current_reg_id) {

								    case 1:
								        $filter = 1886;
								        break;
								    case 2:
								        $filter = 1882;
								        break;
								    case 3:
								        $filter = 1887;
								        break;
								    case 4:
								        $filter = 1885;
								        break;
								    case 5:
								        $filter = 1881;
								        break;
								    case 6:
								        $filter = 1883;
								        break;
								    case 7:
								        $filter = 1888;
								        break;
								    case 8:
								        $filter = 1880;
								        break;
								    case 9:
								        $filter = 1879;
								        break;
                    case 10:
                        $filter = 1905;
                        break;
								    
								  
						      }

                	    $url = 'https://intraservice.ugmk-telecom.ru/api/task?CreatedMoreThan='.$req->get('date_from').'&CreatedLessThan='.$req->get('date_to').'&filterid='.$filter.'&pagesize=2000&fields=Id,Name,ServiceId,StatusId,Created,Closed,Data,TypeId,Type';

                }else{

                	$url = 'https://intraservice.ugmk-telecom.ru/api/task?CreatedMoreThan='.$req->get('date_from').'&CreatedLessThan='.$req->get('date_to').'&filterid=1889&fields=Id,Name,ServiceId,StatusId,Created,Closed,Data,TypeId,Type&pagesize=2000';
                }

                $auth = base64_encode("gaa1:gaa10711");


                $headers = array(
                          "Authorization: Basic $auth",
                 );
                $context = stream_context_create([
                 "http" => [
                       "header" => implode("\r\n", $headers),
                       
                 ]
                ]);

                 $res = file_get_contents($url, false, $context );

                 $result = json_decode($res, true);


                foreach ($result['Tasks'] as $key => $value){
                        $data = array();
                        if($value['Data']){


		                    $arr = explode("<field", $value['Data']);
		                    $new_array = array_filter($arr, function($element) { return $element !== ""; });

		                    foreach ($new_array as  $val){

		                       $data[] = explode(">", trim($val));
		                    }
                        }
                        $result['Tasks'][$key]['data2'] = $data;

                }

	            return $this->render('check_to',['regions' => $regions,'data_str' => $data_str, 'current_reg' =>  $current_reg ,'array' => $result['Tasks']]);

            }else  return $this->render('check_to',['regions' => $regions]);

    }



} 


 
