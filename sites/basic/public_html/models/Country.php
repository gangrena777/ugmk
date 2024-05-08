<?php

namespace app\models;

use yii\db\ActiveRecord;

class Country extends ActiveRecord
{


    public static function tableName()
    {
        return 'country';
    }
 


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
            [['name', 'code', 'population'], 'required'],
            // email has to be a valid email address
            [['population'], 'integer', 'min' => 3],
            [['code'], 'string', 'min' => 2],
            ['code', 'match', 'pattern' => '/([A-Z])$/'],  //Только заглавные буквы
          
           // ['code', 'filter', 'filter'=> 'strtoupper']

       
        ];
    }

    // public function save($email)
    // {
    //     if ($this->validate()) {
    //         Yii::$app->mailer->compose()
    //             ->setTo($email)
    //             ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
    //             ->setReplyTo([$this->email => $this->name])
    //             ->setSubject($this->subject)
    //             ->setTextBody($this->body)
    //             ->send();

    //         return true;
    //     }
    //     return false;
    // }
}