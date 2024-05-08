<?php

namespace app\controllers;
use yii\filters\AccessControl;

use app\models\Dogovor;
use app\models\DogovorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Region;
use app\models\Tasks;


/**
 * DogovorController implements the CRUD actions for Dogovor model.
 */
class DogovorController extends Controller
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
     * Lists all Dogovor models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DogovorSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $regions = $this->findRegions();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'regions' => $regions
        ]);
    }

    /**
     * Displays a single Dogovor model.
     * @param int $ID ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($ID),
        ]);
    }

    /**
     * Creates a new Dogovor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Dogovor();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'ID' => $model->ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Dogovor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $ID ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($ID)
    {
        $model = $this->findModel($ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'ID' => $model->ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Dogovor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $ID ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($ID)
    {
        $this->findModel($ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dogovor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $ID ID
     * @return Dogovor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($ID)
    {
        if (($model = Dogovor::findOne(['ID' => $ID])) !== null) {
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

}

 
