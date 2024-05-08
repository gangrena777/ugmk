<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "journal".
 *
 * @property int $id
 * @property string $journal_name
 * @property string $journal_path
 * @property int $journal_task_id
 */
class Journal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'journal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['journal_name', 'journal_path', 'journal_task_id'], 'required'],
            [['journal_task_id'], 'integer'],
            [['journal_name', 'journal_path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'journal_name' => 'Journal Name',
            'journal_path' => 'Journal Path',
            'journal_task_id' => 'Journal Task ID',
        ];
    }

      public function getTask()
    {
        return $this->hasOne(Tasks::className(), [ 'id' =>'journal_task_id']);
    }

}
