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

use Shuchkin\SimpleXLSX;
use yii\web\UploadedFile;



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
                    'only' => ['index', 'view','create', 'update','delete','createfile'],
                    'rules' => [
                        [
                          'allow' => true,
                          'actions' => ['index', 'view','create', 'update','delete','createfile'],
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

    protected function getFiles($data){
   
            foreach ($data as $file) {
                // Проверяем, что файл с расширением .xlsx
                if ($file->extension === 'xlsx') {
                    // Проверяем, что класс SimpleXLSX существует
                    if (class_exists('Shuchkin\SimpleXLSX')) {
                        // Пытаемся загрузить файл
                        try {
                            $xlsx = SimpleXLSX::parse($file->tempName);
                            if ($xlsx) {
                                $rows = $xlsx->rows(); // Получаем данные из файла
                                // Пропускаем первую строку с заголовками
                                $header_values = array_shift($rows);
                                // Создаем ассоциативный массив данных
                                foreach ($rows as $row) {

                                   // $dataz[] = array_combine($header_values, $row);
                                  yield   array_combine($header_values, $row);
                                }
                            } else {
                                Yii::$app->session->setFlash('error', 'Ошибка парсинга файла: ' . SimpleXLSX::parseError());
                            }
                        } catch (\Exception $e) {
                            Yii::$app->session->setFlash('error', 'Ошибка при чтении файла ' . $file->name . ': ' . $e->getMessage());
                        }
                    } else {
                        Yii::$app->session->setFlash('error', 'Класс SimpleXLSX не найден');
                    }
                }else{
                    Yii::$app->session->setFlash('error', 'this is no xslx');
                }
            }
              
    }

    public function actionCreatefile()
    {
          $dataz = [];
          $error = [];
        if (Yii::$app->request->isPost) {

            
            $uploaded_files = UploadedFile::getInstancesByName('files');

            
            $data = $this->getFiles($uploaded_files);

          

            foreach ($data as $key => $value) {
                $model = new Services();
                $model->SERV_ID = $value['Id'];
                $model->CODE = $value['Code'];
                $model->NAME = $value['Name'];
                $model->DESCRIPTION = $value['Description'];
                $model->ParentId = $value['ParentId'];
                $model->isArchiv = $value['IsArchive'];
                $model->isPublic = $value['IsPublic'];
                $model->Path = $value['Path'];
                $model->GUID = $value['Guid'];
                $model->Attribut_dogovor = $value['Атрибут договора'];
                if($model->save(false)){
                    $dataz[] = $value;
                }else{
                     $error[] = $value;
                }
                
              
            }



            return $this->render('createfile', [
                 'dataz' => $dataz
            ]);

        }else{
              return $this->render('createfile', [
                'error' =>$error
              ]);
        }


    }

  


}
