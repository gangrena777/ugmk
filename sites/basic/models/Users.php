<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string $role
 * @property int $reg_see
 * @property int $password
 * @property int $authKey
 * @property string $accessToken
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'role', 'reg_see', 'password', 'authKey', 'accessToken'], 'required'],
            [['reg_see', 'password', 'authKey'], 'integer'],
            [['username', 'accessToken'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'role' => 'Role',
            'reg_see' => 'Reg See',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'accessToken' => 'Access Token',
        ];
    }
}
