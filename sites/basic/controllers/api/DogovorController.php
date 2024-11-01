<?php

namespace app\controllers\api;

use app\models\Dogovor;
use app\models\DogovorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\rest\ActiveController;

  


class DogovorController extends ActiveController
{
	  public $modelClass = 'app\models\Dogovor';

	  protected function verbs()
     {
		    return [
		        'index' => ['GET', 'HEAD'],
		        'view' => ['GET', 'HEAD'],
		        'create' => ['POST'],
		        'update' => ['PUT', 'PATCH'],
		        'delete' => ['DELETE'],
		    ];
    }
  
}
