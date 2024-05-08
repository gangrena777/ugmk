<?php

namespace app\models;

use Yii;

use app\models\Region;
use app\models\Services;


/**
 * This is the model class for table "Dogovor".
 *
 * @property int $ID
 * @property string $CODE
 * @property string $CONTRAGENT
 * @property string $GUID
 * @property string $ATTRIBUT
 * @property string $PLAN
 * @property string $PERIOD
 * @property int $REGION_ID
 * @property string $NAME_NG
 * @property string $CODE_NG
 * @property string $USE_TMC
 */
class Dogovor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'Dogovor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['CODE', 'CONTRAGENT', 'GUID', 'ATTRIBUT', 'PLAN', 'PERIOD', 'REGION_ID', 'NAME_NG', 'CODE_NG', 'USE_TMC'], 'required'],
            [['PERIOD'], 'safe'],
            [['REGION_ID'], 'integer'],
            [['CODE', 'CONTRAGENT', 'GUID', 'ATTRIBUT', 'PLAN', 'NAME_NG', 'CODE_NG', 'USE_TMC'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'CODE' => 'Номер договора',
            'CONTRAGENT' => 'Контрагент',
            'GUID' => 'Guid',
            'ATTRIBUT' => 'Аттрибут договора',
            'PLAN' => 'Длан часов в месяц',
            'PERIOD' => 'Period',
            'REGION_ID' => 'Участок',
            'NAME_NG' => 'Название НГ',
            'CODE_NG' => 'Код НГ',
            'USE_TMC' => 'Назначения использования ТМЦ',
        ];
    }

     public function getRegion()
    {
        return $this->hasOne(Region::className(), ['id' => 'REGION_ID']);
    }

    public function getServices()
    {
        return $this->hasMany(Services::className(), ['Attribut_dogovor' => 'ATTRIBUT']);

    }


}
