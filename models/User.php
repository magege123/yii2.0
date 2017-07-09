<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $uid
 * @property string $nickname
 * @property string $mobile
 * @property string $email
 * @property integer $sex
 * @property string $avatar
 * @property string $login_name
 * @property string $login_pwd
 * @property string $login_salt
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    //生成加密密码
    public function getSaltPwd($password){
        return md5($password.md5($this->login_salt));
    }

    //校验密码是否一致
    public function verify($password){
        return $this->getSaltPwd($password) == $this->login_pwd;
    }

    //设置新密码
    public function setNewPwd($password){
        $this->login_pwd = $this->getSaltPwd($password);
    }


    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['nickname', 'email'], 'string', 'max' => 100],
            [['mobile', 'login_name'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 64],
            [['login_pwd', 'login_salt'], 'string', 'max' => 32],
            [['login_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'nickname' => 'Nickname',
            'mobile' => 'Mobile',
            'email' => 'Email',
            'sex' => 'Sex',
            'avatar' => 'Avatar',
            'login_name' => 'Login Name',
            'login_pwd' => 'Login Pwd',
            'login_salt' => 'Login Salt',
            'status' => 'Status',
            'updated_time' => 'Updated Time',
            'created_time' => 'Created Time',
        ];
    }
}
