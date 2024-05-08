<?php

namespace app\models;

use Yii;
use app\models\Region;
use app\models\Dogovor;

/**
 * This is the model class for table "services".
 *
 * @property string|null $SERV_ID
 * @property string|null $CODE
 * @property string|null $NAME
 * @property string|null $DESCRIPTION
 * @property string|null $isArchiv
 * @property string|null $isPublic
 * @property string|null $ParentId
 * @property string|null $Path
 * @property string|null $GUID
 * @property string|null $Attribut_dogovor
 */
class Services extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['SERV_ID'], 'string', 'max' => 7],
            [['CODE'], 'string', 'max' => 15],
            [['NAME'], 'string', 'max' => 143],
            [['DESCRIPTION'], 'string', 'max' => 4400],
            [['isArchiv', 'isPublic'], 'string', 'max' => 10],
            [['ParentId'], 'string', 'max' => 8],
            [['Path'], 'string', 'max' => 25],
            [['GUID'], 'string', 'max' => 40],
            [['Attribut_dogovor'], 'string', 'max' => 16],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'SERV_ID' => 'Serv ID',
            'CODE' => 'Code',
            'NAME' => 'Name',
            'DESCRIPTION' => 'Description',
            'isArchiv' => 'Is Archiv',
            'isPublic' => 'Is Public',
            'ParentId' => 'Parent ID',
            'Path' => 'Path',
            'GUID' => 'Guid',
            'Attribut_dogovor' => 'Attribut Dogovor',
        ];
    }

        public function getDogovor()
    {
        return $this->hasOne(Dogovor::className(), ['ATTRIBUT' => 'Attribut_dogovor']);
    }
}
