<?php

namespace app\controllers;
use Yii;

use yii\filters\AccessControl;
use app\models\Services;
use app\models\ServiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Dogovor;

/**
 * ServiceController implements the CRUD actions for Services model.
 */
class ServiceController extends Controller
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
     * Lists all Services models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ServiceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Services model.
     * @param int $SERV_ID Serv ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($SERV_ID)
    {
        return $this->render('view', [
            'model' => $this->findModel($SERV_ID),
        ]);
    }

    /**
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Services();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'SERV_ID' => $model->SERV_ID]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Services model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $SERV_ID Serv ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($SERV_ID)
    {
        $model = $this->findModel($SERV_ID);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'SERV_ID' => $model->SERV_ID]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Services model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $SERV_ID Serv ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($SERV_ID)
    {
        $this->findModel($SERV_ID)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $SERV_ID Serv ID
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($SERV_ID)
    {
        if (($model = Services::findOne(['SERV_ID' => $SERV_ID])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
