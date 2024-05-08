<?php

namespace app\models;

use Yii;

use app\models\Dogovor;


/**
 * This is the model class for table "region".
 *
 * @property int $id
 * @property string $region_name
 */
class Region extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['region_name'], 'required'],
            [['region_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'region_name' => 'Участок',
        ];
    }


    public function getDogovors(){

         return $this->hasMany(Dogovor::className(), ['REGION_ID' => 'id']);
    }
}
