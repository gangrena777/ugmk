<?
namespace app\controllers\api;

use app\models\Tasks;
use app\models\TasksSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\rest\ActiveController;

use yii\filters\auth\HttpBasicAuth;

  


class TasksController extends ActiveController
{
        public $modelClass = 'app\models\Tasks';


        // public function behaviors()
        // {
        //     $behaviors = parent::behaviors();
        //     $behaviors['authenticator'] = [
        //         'class' => HttpBasicAuth::className(),
             
        //     ];

        //     return $behaviors;
        // }

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
?>