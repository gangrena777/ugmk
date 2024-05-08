<?php

namespace app\models;

use Yii;

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;
?>
<?php

/**
 * This is the model class for table "otziv".
 *
 * @property integer $id
 * @property integer $otziv_id_prod
 * @property string $plus_otziv
 * @property string $minus_otsiv
 * @property string $otsiv_text
 * @property integer $mark

 * @property integer $auth
 */
class Photos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'name','path','object_id'], 'required'],
            [['object_id'], 'integer'],
            [['name','path'], 'string'],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'path' => 'Путь',
            'object_id' => 'object_id'
        ];
          
    }

     public function getObject ()
    {
        return $this->hasOne(Objects::className(), [ 'id' => 'object_id']);
    }
}