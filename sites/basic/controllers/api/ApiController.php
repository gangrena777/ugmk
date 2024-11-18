<?php

namespace app\controllers\api;


use Yii;
use app\models\Dogovor;
use app\models\DogovorSearch;
use app\models\Services;
use app\models\Region;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\rest\ActiveController;

  


class ApiController extends Controller
{
	  
 
    public function actionIndex()
    {
        return 'api';
    }

    public function actionGet($date_from, $date_to){
    	
    	return $date_from."___".$date_to;
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


    public  function actionGettask(){
    	         
        $req = Yii::$app->request;
          if(  $req->get('date_from')  && $req->get('date_to') ){


                      $from = $req->get('date_from');
                      $to = $req->get('date_to');


                      // $data_str = $req->get('date_from')." --  ".$req->get('date_to');

                      // $data_str = $date_from." --  ".$date_to;
                  


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

                        return json_encode($NewArr);

         }else return "ERROR";

    }

  
}
