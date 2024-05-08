<?php

namespace app\controllers;
use Yii;
use app\models\Objects;
use app\models\ObjectsSearch;

use app\models\Photos;

use app\models\Documents;
use app\models\Video;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\web\UploadedFile;
use yii\helpers\Url;

/**
 * ObjectsController implements the CRUD actions for Objects model.
 */
class ObjectsController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Objects models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ObjectsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
            
        ]);
    }

    /**
     * Displays a single Objects model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {


        $PHOTOS = Photos::find()->where(['object_id' => $id])->all();

         $DOCS = Documents::find()->where(['doc_object_id' => $id])->all();

         $VIDEO = Video::find()->where(['object_id' => $id])->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'photos' =>$PHOTOS,
            'documents' =>$DOCS,
            'video' =>$VIDEO
        ]);
    }

    /**
     * Creates a new Objects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Objects();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {

                    $model->photos = UploadedFile::getInstances($model, 'photos');

                       $model->documents = UploadedFile::getInstances($model, 'documents');

                    $id = Yii::$app->db->getLastInsertID();
                  
                    if($model->photos ) {

                       
                        $model->uploadPhotos($id);

                    }
                    if($model->documents){
                        $model->uploadDocs($id);
                    }
               
               //unset($model->photos);

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
     * Updates an existing Objects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model  = $this->findModel($id);

        $PHOTOS = Photos::find()->where(['object_id' => $model->id])->all();

        $DOCS   = Documents::find()->where(['doc_object_id' => $model->id])->all(); 

        $VIDEO  = Video::find()->where(['object_id' => $model->id])->all();
  

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {

                $model->photos = UploadedFile::getInstances($model, 'photos');
                   if($model->photos ) {
                        $model->uploadPhotos($id);

                   }

                $model->documents = UploadedFile::getInstances($model, 'documents');
                   if($model->documents ) {
                        $model->uploadDocs($id);
                    }

                $model->video = UploadedFile::getInstances($model, 'video');
                   if($model->video ) {
                        $model->uploadVideo($id);

                   }
       
               
           

               return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'photos'=>$PHOTOS,
            'documents' =>$DOCS,
            'video' =>$VIDEO


        ]);
    }

    /**
     * Deletes an existing Objects model.
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
     * Finds the Objects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Objects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Objects::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionDeletephoto ($id_photo)
    {
        
        $delete_from_model = Photos::find()->where(['id'=> $id_photo])->one()->delete();

    }

    public function actionDeletedoc ($id_doc)
    {
        


        $delete_from_model = Documents::find()->where(['id'=> $id_doc])->one()->delete();

    }


}
