<?php

namespace common\models\user;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "diyou_users".
 *
 * @property string $user_id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property integer $tuijian_userid
 * @property string $paypassword
 * @property integer $logintime
 * @property string $reg_ip
 * @property integer $reg_time
 * @property string $up_ip
 * @property integer $up_time
 * @property string $last_ip
 * @property integer $last_time
 * @property integer $block_status
 * @property integer $user_role
 * @property integer $import_time
 * @property integer $reg_type
 * @property string $import_phone
 * @property string $import_pwd
 * @property integer $user_type
 * @property integer $import_status
 * @property integer $app_status
 * @property string $app_name
 * @property integer $app_send
 * @property integer $app_add_time
 * @property integer $app_login_time
 * @property integer $app_pwd
 * @property integer $import_resend
 * @property integer $autorepay_status
 * @property string $autorepay_types
 * @property integer $autorepay_first
 * @property string $yeebaopayid
 * @property integer $status
 */

 class Diyouuser extends  \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public  $auth_key;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password', 'reg_ip', 'reg_time', 'up_ip', 'up_time', 'last_ip', 'last_time', 'block_status', 'app_name', 'app_login_time', 'app_pwd', 'autorepay_status', 'autorepay_types', 'autorepay_first'], 'required'],
            [['tuijian_userid', 'logintime', 'reg_time', 'up_time', 'last_time', 'block_status', 'user_role', 'import_time', 'reg_type', 'user_type', 'import_status', 'app_status', 'app_send', 'app_add_time', 'app_login_time', 'app_pwd', 'import_resend', 'autorepay_status', 'autorepay_first', 'status'], 'integer'],
            [['username', 'email', 'password', 'import_pwd'], 'string', 'max' => 32],
            [['paypassword', 'app_name'], 'string', 'max' => 100],
            [['reg_ip', 'up_ip', 'last_ip'], 'string', 'max' => 15],
            [['import_phone'], 'string', 'max' => 20],
            [['autorepay_types', 'yeebaopayid'], 'string', 'max' => 50],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'tuijian_userid' => 'Tuijian Userid',
            'paypassword' => 'Paypassword',
            'logintime' => 'Logintime',
            'reg_ip' => 'Reg Ip',
            'reg_time' => 'Reg Time',
            'up_ip' => 'Up Ip',
            'up_time' => 'Up Time',
            'last_ip' => 'Last Ip',
            'last_time' => 'Last Time',
            'block_status' => 'Block Status',
            'user_role' => 'User Role',
            'import_time' => 'Import Time',
            'reg_type' => 'Reg Type',
            'import_phone' => 'Import Phone',
            'import_pwd' => 'Import Pwd',
            'user_type' => 'User Type',
            'import_status' => 'Import Status',
            'app_status' => 'App Status',
            'app_name' => 'App Name',
            'app_send' => 'App Send',
            'app_add_time' => 'App Add Time',
            'app_login_time' => 'App Login Time',
            'app_pwd' => 'App Pwd',
            'import_resend' => 'Import Resend',
            'autorepay_status' => 'Autorepay Status',
            'autorepay_types' => 'Autorepay Types',
            'autorepay_first' => 'Autorepay First',
            'yeebaopayid' => 'Yeebaopayid',
            'status' => 'Status',
        ];
    }

    /**
     * @inheritdoc
     * @return Admin
     */
    public static function findIdentity($id)
    {
        return static::findOne(['user_id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public static function findById($id)
    {
        return self::find()->where('user_id = :id', [':id' => $id])->one();
    }

    /*
     * @return Admin
     * */
    public static function findByName($name)
    {
        return self::find()->where('username = :name ', [':name' => $name])->one();

    }

    /*
     * 查询所有管理员
     * @return array
     * */
    public static function listAll()
    {
        return self::find()->where('deleted = 0')->all();
    }

    public static function loginLog($ip)
    {

    }

    public static function realNameMap()
    {
        $names = self::find()->select('id,real_name')->where('deleted = 0')->asArray()->all();
        return ArrayHelper::map($names,'id','real_name');
    }







}
