<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\ContactForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\captcha\Captcha;


use yii\widgets\Pjax;
use yii\grid\GridView;

use yii\data\ActiveDataProvider;



$this->title = 'Contact';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>



<? phpinfo();?>
<?

/*

//$dsn = 'sqlsrv:dbname=Intraservice;host=46.160.161.204:1433';
//$conn = new PDO("sqlsrv:Server=localhost;Database=testdb", "UserName", "Password"); 

$user = 'INTRASERVICE\IntraS';
$password = '';
//$link = new PDO($dsn, $user, $password);
$link = new PDO("mssql:host=46.160.161.204:1433;dbname=Intraservice", $user, $password); 

if (!$link)
die('Unable to connect!');

$query="EXEC  get_taskexpenses_from_intraservice";

$statement = $link->prepare($query);
$statement->execute();

header('Content-type: application/txt; charset=utf-8'); //тут тип
header('Content-Disposition: attachment; filename="'.date('Ymd').'_report.csv"');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private',false);

// разделитель полей
$DIV="\t";

$pattern=array("\n", "\t", "\"");
// вывод заголовков полей
foreach(range(0, $statement->columnCount() - 1) as $column_index)
{
  $field_meta = $statement->getColumnMeta($column_index);
  echo "\"".str_replace($pattern, ' ', $field_meta['name'])."\"".$DIV;

}
echo "\n";

//вывод данных
while( $row =  $statement->fetch(PDO::FETCH_NUM)){
  foreach ($row as $v2){
    echo "\"".str_replace($pattern, ' ', $v2)."\"".$DIV;
  }
  echo "\n";
}
*/
?>


</div>




