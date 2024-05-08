<?php

namespace app\models;

use yii\web\UploadedFile;
use app\models\Journal;

use Yii;

/**
 * This is the model class for table "Tasks".
 *
 * @property int $id
 * @property int $region_id
 * @property string $dogovor_code
 * @property string $task_name
 * @property int $task_id
 * @property int $journal_id
 * @property string $date_create
 */
class Tasks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $journal;
    
    public static function tableName()
    {
        return 'Tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
                 [['region_id', 'dogovor_code', 'task_name', 'task_id',  'date_create'], 'required'],
                 [['region_id', 'task_id', 'journal_id'], 'integer'],
                 [['date_create'], 'safe'],
                 [['dogovor_code', 'task_name'], 'string', 'max' => 255],
                 [['journal'], 'file', 'extensions'=>'csv, jpg, gif, png, doc, txt, pdf ,docx ,rar ,zip ,xls ,xlsx, rtf, php, sql, log',
                   'checkExtensionByMimeType'=> false  ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_id' => 'Регион(ID)',
            'dogovor_code' => 'Код договора',
            'task_name' => 'Наименование заявки',
            'task_id' => 'ID заявки( intaservice )',
            'journal_id' => 'Документы',
            'date_create' => 'Дата создания',
        ];
    }

      public function getJournal()
    {
        return $this->hasMany(Journal::className(), [ 'journal_task_id' => 'id']);
    }


    public function UploadJournal($id)
    {
      

            foreach ($this->journal  as $jour) 
            {
                 $path = 'upload/journals/'. $jour->baseName . '.' . $jour->extension;
                 if($jour->saveAs($path)){


                      $this->SaveDbJournals($jour, $path, $id);
                }
            }
            
            return true;
     
    }

    public function SaveDbJournals($jour, $path, $id)
    {
              $DOCS = new Journal();

                    $values = [
                        'journal_name' => $jour->baseName . '.' . $jour->extension,
                        //'path' => substr($path,2),
                        'journal_path' => $path,
                        'journal_task_id' =>$id
                    ];
                    $DOCS->attributes = $values;
                   if($DOCS->save()){

                   }

                    unset($model->journal);


    }


}
