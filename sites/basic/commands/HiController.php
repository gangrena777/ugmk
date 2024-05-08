<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

//namespace yii\console\controllers;
namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;


 
class HiController extends Controller
{
  
  public function actionIndex($message = 'hi amigo')
    {
       // echo $message . "\n";

       // return ExitCode::OK;

          $db = yii::$app->rabbitmq;

         print_r($db);
    }
}

