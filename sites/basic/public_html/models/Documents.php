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
class Documents extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'doc_name','doc_path','doc_object_id'], 'required'],
            [['doc_object_id'], 'integer'],
            [['doc_name','doc_path'], 'string'],
          
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'doc_name' => 'Название',
            'doc_path' => 'Путь',
            'doc_object_id' => 'object_id'
          ];
    }

     public function getObject ()
    {
        return $this->hasOne(Objects::className(), [ 'id' => 'doc_object_id']);
    }
}