<?php

namespace app\models;

use yii\web\UploadedFile;

use Yii;

/**
 * This is the model class for table "objects".
 *
 * @property int $id
 * @property string $name
 * @property string $addres
 * @property string $description
 * @property string $communications
 * @property string $info
 */
class Objects extends \yii\db\ActiveRecord
{

    public $photo;
    public $document;
    /**
     * {@inheritdoc}
     */

     public function behaviors()
    {
   
    }
    public static function tableName()
    {
        return 'object';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'addres', 'description', 'communications', 'info'], 'required'],
            [['info'], 'string'],
            [['name', 'addres', 'description', 'communications'], 'string', 'max' => 255],
            [['photos'], 'file'],
            [['documents'], 'file']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'addres' => 'Addres',
            'description' => 'Description',
            'communications' => 'Communications',
            'info' => 'Info',
            'Photos' => 'Photos',
            'documents' =>'Documents'
        ];
    }
}
