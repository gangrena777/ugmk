<?php

namespace app\models;
use yii\web\UploadedFile;

use Yii;

/**
 * This is the model class for table "object".
 *
 * @property int $id
 * @property string $name
 * @property string $addres
 * @property string $communications
 * @property string $info
 * @property string $description
 */
class Objects extends \yii\db\ActiveRecord
{

    public $photos;
    public $documents;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'object';
    }

    //    public function behaviors()
    // {
    //     return [
    //         'photos' => [
    //             'class' => 'rico\yii2images\behaviors\ImageBehave',
    //         ]
    //     ];
    // }

    //

    /**
     * {@inheritdoc}


     */
    public function rules()
    {
        return [
            [['name', 'addres', 'communications', 'info', 'description'], 'required'],
            [['info'], 'string'],
            [['name', 'addres', 'communications', 'description'], 'string', 'max' => 255],
            [['photos'], 'image','maxFiles' => 10],
            [['documents'], 'file', 'extensions'=>'csv, jpg, gif, png, doc, txt, pdf ,docx ,rar ,zip ,xls ,xlsx, rtf, php, sql, log',
               'checkExtensionByMimeType'=> false,   
               // 'mimeTypes'=>'image/jpeg,image/png,application/msword doc,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/pdf,text/plain,text/x-log'
            ]  

            // [['documents'], 'file', 'skipOnEmpty' => false, 'extensions'=>['xls', 'csv','php','xlsx'], 'checkExtensionByMimeType'=>false, 'maxSize'=>1024 * 1024 * 2]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'addres' => 'Адресс',
            'communications' => 'Коммуникации',
            'info' => 'Информация об обьекте',
            'description' => 'Описание',
            'photos' =>'Фото обьекта',
            'documents' =>'Инструкции и документы'
        ];
    }

    //   if(Yii::$app->request->isPost){
    //     $model->image = UploadedFile::getInstance($model, 'image');
    //     $model->upload();
    //     return;
    // }


          public function upload($dir)
    {
        if ($this->validate()) {
             $path = '../api-bot/assets/' .$dir.'/'. $this->photos->baseName . '.' . $this->photos->extension;
             $this->photos->saveAs($path);
            // //$this->attachImage($path, true);
            // //@unlink($path);


            return true;
        } else {
            return false;
        }
    }


     public function UploadPhotos($id)
    {
        if ($this->validate()) 
        {   

            foreach ($this->photos  as $photo) 
            {
                 $path = 'upload/photos/'. $photo->baseName . '.' . $photo->extension;
                 if($photo->saveAs($path)){

                      $this->SaveDbPhoto($photo, $path, $id);
                }
            }
            
            return true;
        } 
        else 
        {
            return false;
        }
    }

        public function UploadDocs($id)
    {
       // if ($this->validate()) 
       // {   
           

            foreach ($this->documents  as $doc) 
            {
                 $path = 'upload/documents/'. $doc->baseName . '.' . $doc->extension;
                 if($doc->saveAs($path)){


                      $this->SaveDbDocs($doc, $path, $id);
                }
            }
            
            return true;
        //} 
        // else 
        // {
        //    var_dump($this->documents);
        //     return false;
        // }
    }

    public function getPhotos()
    {
        return $this->hasMany(Photos::className(), [ 'object_id' => 'id']);
    }

    public function getDocuments()
    {
        return $this->hasMany(Documents::className(), [ 'doc_object_id' => 'id']);
    }

    public function SaveDbPhoto($photo, $path, $id){
              $PHOTOS = new Photos();

                    $values = [
                        'name' => $photo->baseName . '.' . $photo->extension,
                        //'path' => substr($path,2),
                        'path' => $path,
                        'object_id' =>$id
                    ];
                    $PHOTOS->attributes = $values;
                    $PHOTOS->save();
                     unset($model->photos);
              
    }

    public function SaveDbDocs($doc, $path, $id){
              $DOCS = new Documents();

                    $values = [
                        'doc_name' => $doc->baseName . '.' . $doc->extension,
                        //'path' => substr($path,2),
                        'doc_path' => $path,
                        'doc_object_id' =>$id
                    ];
                    $DOCS->attributes = $values;
                    $DOCS->save();

                    unset($model->documents);
    }
}
