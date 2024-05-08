<?php

namespace app\controllers;
use Yii;

use yii\filters\AccessControl;

use yii\web\Response;


use app\models\Tasks;
use app\models\TasksSearch;

use app\models\Region;
use app\models\Journal;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;



use yii\web\UploadedFile;
use yii\helpers\Url;



/**
 * TasksController implements the CRUD actions for Tasks model.
 */
class TasksController extends Controller
{
    /**
     * @inheritDoc
     */
     public function behaviors()
    {
        return [
              'access' => [
                    'class' => AccessControl::className(),
                    'only' => ['index', 'view','create', 'update','delete'],
                    'rules' => [
                        [
                          'allow' => true,
                          'actions' => ['index', 'view','create', 'update','delete'],
                          'roles' => ['admin'],

                        ],
                                                [
                          'allow' => true,
                          'actions' => ['index', 'view', 'update'],
                          'roles' => ['user'],
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
     * Lists all Tasks models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TasksSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $regions  = $this->findRegions();




        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'regions' => $regions
        ]);
    }

    /**
     * Displays a single Tasks model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
   {

        $regions  = $this->findRegions();

         $JOURNALS = Journal::find()->where(['journal_task_id' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'regions' => $regions,
            'journals' =>$JOURNALS
        ]);
    }

    /**
     * Creates a new Tasks model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tasks();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                $model->journal = UploadedFile::getInstances($model, 'journal');
                $id = Yii::$app->db->getLastInsertID();
                  
                if($model->journal) {
                      $model->UploadJournal($id);


                }


                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tasks model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model  = $this->findModel($id);

        $JOURNALS = Journal::find()->where(['journal_task_id' => $model->id])->all();

         if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

                $model->journal = UploadedFile::getInstances($model, 'journal');
                   if($model->journal ) {
                        $model->UploadJournal($id);

                   }

               
           

               return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'journals'=>$JOURNALS,
            


        ]);
    }

    /**
     * Deletes an existing Tasks model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tasks model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Tasks the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tasks::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

       protected function findRegions(){

      $regions =   $regions  = Region::find()->all();
      $regs = array();
      foreach ($regions as  $value) {
          $regs[$value->id] =$value->region_name;
      }
      return $regs;
    }

       public function actionDeletedoc ($id_doc)
    {
        
        $delete_from_model = Journal::find()->where(['id'=> $id_doc])->one()->delete();
    }
}
