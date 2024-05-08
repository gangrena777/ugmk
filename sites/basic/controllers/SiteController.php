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



use yii\data\Pagination;



use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use mikemadisonweb\rabbitmq\components\Producer;
use mikemadisonweb\rabbitmq\Configuration;


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
                    'only' => ['login', 'logout', 'signup','about', 'report'],
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
                          'actions' => ['about', 'report'],
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
             return $this->render('contact');
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

    // public function actionRabbit()
    // {
    // 	$model = new Country();

    //       $model2 = new ContactForm();

    //       $countries = Country::find()->orderBy('name')->all();



    // 	if($model->load(Yii::$app->request->post()) && $model->validate() ){

    //         // if( $model->save() ) {
    //         //     return $this->refresh();
    		 	
    //         // }

          

    //         $producer = \Yii::$app->rabbitmq->getProducer('producer-name2');
    //         $msg = json_encode(['name'=>$model->name, 'code'=>$model->code, 'population'=>$model->population]);
    //         $producer->publish($msg, 'exchange-name','second_key');
           
    //         // exit;
    //          return $this->refresh();
    // 	}
    // 	return $this->render('rabbit',['model' => $model,

    //            'dataProvider' => $countries,
    //            'model2' => $model2,
    //           ]);
    // }


    // public function actionPjaxCountry()
    // {
          
    //         // получаем все строки из таблицы "country" и сортируем их по "name"
    //         $countries = Country::find()->orderBy('name')->all();

    //          /* @var $dataProvider yii\data\ActiveDataProvider */
       
    //         $model2 = new ContactForm();
    //           $model = new Country();


    //          return $this->render('rabbit', [ 

    //          'dataProvider' => $countries,
    //           'model' => $model,
    //            'model2' => $model2,
    //            'countries' => $countries,

    //        ]);
    // }
    //    public function actionPjax()
    // {
             

    //          $security = new \yii\base\Security();

    //          $req = Yii::$app->request;
    //          $action = $req->get('action');
       

    //          if ($action == "string") {
    //               return $this->render('pjax', [
    //                   'string' => $security->generateRandomString(),
              
    //              ]);

    //           }
    //           else  if ($action == "time") {
    //               return $this->render('pjax', [
    //                   'time' => date('H:i:s')
              
    //                ]);

    //           }

    
    
    //           else {

    //               $countries = Country::find()->orderBy('name')->all();


    //               $searchModel = [
    //                   'code' => mb_strtoupper(Yii::$app->request->getQueryParam('filtercode', '')),
    //               ];

    //               $filteredData = array_filter($countries, function($item) use ($searchModel) {
    //                   if (!empty($searchModel['code'])) {
    //                       if ($item['code'] == $searchModel['code']) {
    //                           return true;
    //                       } else {
    //                           return false;
    //                       }
    //                   } else {
    //                       return true;
    //                   }
    //               });

    //               //use yii\data\ActiveDataProvider;
    //               $dataProvider = new \yii\data\ArrayDataProvider([
    //                   'key' => 'id',
    //                   'allModels' =>$filteredData,
    //                   'sort' => [
    //                       'attributes' => ['name'],
    //                   ],
    //                   'pagination' => [
    //                       'pageSize' => 3,
    //                   ],
    //               ]);

                

    //                   return $this->render('pjax', [

    //                       'key' => $security->generateRandomKey(),
    //                       'dataProvider' => $dataProvider,
    //                       'searchModel' => $searchModel

    //                    ]);
    //            }


    // }

    protected function findRegions(){

      $regions  = Region::find()->all();
      $regs = array();
      foreach ($regions as  $value) {
          $regs[$value->id] = $value->region_name;
      }
      return $regs;
    }

    protected  function getAllServices(){

      $services = Services::find()->select('services.SERV_ID, services.GUID , services.Attribut_dogovor')->joinWith('dogovor')->all();
         
      $SERVICES = array();

      $regions = $this->findRegions();
      foreach ($services as $key => $value) {
             $SERVICES[$value['SERV_ID']]['SERV_ID'] = $value->SERV_ID;
                $SERVICES[$value['SERV_ID']]['GUID'] = $value->GUID;
                  $SERVICES[$value['SERV_ID']]['Attribut_dogovor'] = $value->Attribut_dogovor;
                    $SERVICES[$value['SERV_ID']]['dogovor']['CODE_NG'] = $value->dogovor->CODE_NG ?? 0;
                      $SERVICES[$value['SERV_ID']]['dogovor']['NAME_NG'] = $value->dogovor->NAME_NG ?? 0;
                        $SERVICES[$value['SERV_ID']]['dogovor']['USE_TMC'] = $value->dogovor->USE_TMC ?? 0;
                          $SERVICES[$value['SERV_ID']]['dogovor']['REGION_ID'] = $value->dogovor->REGION_ID ?? 0;

                            $id = $value->dogovor->REGION_ID ?? 0;
                            if( $id > 0){
                              $SERVICES[$value['SERV_ID']]['dogovor']['REGION_NAME'] = $regions[$value->dogovor->REGION_ID];
                            }else{
                               $SERVICES[$value['SERV_ID']]['dogovor']['REGION_NAME'] = '';
                            }
      }
      return $SERVICES;
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


    public function actionReport()
    {

          

          

           $req = Yii::$app->request;
    
      

            if(  $req->get('date_from')  && $req->get('date_to') ){


                    $from = str_replace('-', '', $req->get('date_from'));
                    $to = str_replace('-', '', $req->get('date_to'));

                    $data_str = $req->get('date_from')." --  ".$req->get('date_to');


                    $report = file_get_contents('http://46.160.151.67/intraservice_procs2.php?procedure=get_taskexpenses777&params=date_between&from='.$from.'&to='.$to);

                    $lines = explode(PHP_EOL,  $report);
                    $array = array();


                    $FINALL = array();
                    foreach ($lines as $line) {
                      if($line){

                         $line2 = preg_split('/\"/',$line);
                          $arr = array();
                          $arr['Исполнитель'] = $line2[7];
                      
                         $arr['Дата трудозатрат'] =  $line2[5];
                         $arr['Комментарий'] = isset($line2[9])  ?  $line2[9] : "CCCCCCCCCC";
                         $arr['Код сервиса'] = isset($line2[21]) ? $line2[21]  : "KKKKKKKKK";
                         $arr['№ заявки'] = $line2[1];
                         $arr['Наименование заявки'] = $line2[13];
                         $arr['Заявитель'] = $line2[19];
                         $arr['Индефикатор сервиса'] = intval($line2[15]);
                         $arr['Трудозатраты(мин)'] = isset($line2[11]) ? $line2[11] : 0 ;
                         $arr['Трудозатраты(часы)'] = isset($line2[11]) ? date( "G:i", mktime( 0, intval($line2[11]))) :  0 ;
                         $arr['ЧЧ'] = isset($line2[11]) ? round(floatval($line2[11])/60 , 2) : 0 ;
                         $arr['Статус'] = $line2[23];

                         $array[] = $arr;
                        // $array[] = $line2;
                        

                      }

                    }

                    $services = $this->getAllServices();
                    array_shift($array);
                    $NewArr =[];
                    foreach ($array as $key => $val) {

                        if($val['Статус'] == '28'){
                          //28 - close
                          //29 - done

                         if($val['Индефикатор сервиса'] > 0 ){
                              if(array_key_exists($val['Индефикатор сервиса'], $services )){
                            
                                  $val['Attribut_dogovor'] = $services[$val['Индефикатор сервиса']]['Attribut_dogovor'];

                                  $val['Код НГ'] = $services[$val['Индефикатор сервиса']]['dogovor']['CODE_NG'];
                                  $val['Название НГ'] = $services[$val['Индефикатор сервиса']]['dogovor']['NAME_NG'];
                                  $val['Назначение ТМЦ'] = $services[$val['Индефикатор сервиса']]['dogovor']['USE_TMC'];
                                  $val['Участок'] = $services[$val['Индефикатор сервиса']]['dogovor']['REGION_NAME'];
                              }

                          }else{

                                $val['Attribut_dogovor'] = 0;
                                $val['Код НГ'] = 0;
                                $val['Название НГ'] = '_';
                                $val['Назначение ТМЦ'] = '_';
                                $val['Участок'] = '_';
                          }

                        
                          $NewArr[] = $val;
                        }
                    }

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
                          
                          $NewArr3[$key][$ky]['TOTAL'] = $Total[$key];

                      }
                      
                          
                    }

                              // Yii::$app->mailer->compose()
                              //   ->setFrom(Yii::$app->params['senderEmail'])
                              //  // ->setTo(Yii::$app->params['gaa1@ugmk-telecom.ru'])
                              //   ->setTo('gaa1@ugmk-telecom.ru')
                              //   ->setSubject('Заполнена форма обратной связи')
                              //   ->setTextBody('TEST')
                              //   ->setHtmlBody('<p>TTTTTTTTTTTTTTTTTTTTTTTTTTTTT</p>')
                              //   ->send();


                    return $this->render('report',[
                       'array' => $NewArr3,
                    // 'array' => $NewArr,
                      // 'services' => $services,
                      'data_str' => $data_str
                    ]);
             
            }
             else   return $this->render('report'); 


   
    }
}    