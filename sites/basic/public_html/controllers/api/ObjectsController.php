<?php

namespace app\controllers\api;

use app\models\Objects;
use app\models\ObjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\rest\ActiveController;

  


class ObjectsController extends ActiveController
{
	  public $modelClass = 'app\models\Objects';

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
