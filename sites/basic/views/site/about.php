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
<?


$report = file_get_contents('http://46.160.151.67/intraservice_procs2.php?procedure=get_taskexpenses777&params=date_between&from=20240301&to=20240331&arr=true');




$lines = explode(PHP_EOL,  $report);
$array = array();

foreach ($lines as $line) {
    if($line){

       $line2 = preg_split('/\"/',$line);
       //  $arr = array();
       //  $arr['Исполнитель'] = $line2[7];
    
       // $arr['Дата трудозатрат'] =  $line2[5];
       // $arr['Комментарий'] = isset($line2[9])  ?  $line2[9] : "CCCCCCCCCC";
       // $arr['Код сервиса'] = isset($line2[21]) ? $line2[21]  : "KKKKKKKKK";
       // $arr['№ заявки'] = $line2[1];
       // $arr['Наименование заявки'] = $line2[13];
       // $arr['Заявитель'] = $line2[19];
       // $arr['Индефикатор сервиса'] = $line2[15];
       // $arr['Трудозатраты(мин)'] = isset($line2[11]) ? $line2[11] : 0 ;
       // $arr['Трудозатраты(часы)'] = isset($line2[11]) ? date( "G:i", mktime( 0, intval($line2[11]))) :  0 ;
       // $arr['ЧЧ'] = isset($line2[11]) ? round(floatval($line2[11])/60 , 2) : 0 ;;

       // $array[] = $arr;
       $array[] = $line2;
      

    }

}
//array_shift($array);
echo "<pre>";
print_r($array);
echo "</pre>";





?>



</div>
