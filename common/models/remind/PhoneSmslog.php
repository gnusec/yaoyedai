<?php

namespace common\models\remind;

use Yii;

/**
 * This is the model class for table "diyou_phone_smslog".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $nid
 * @property string $type
 * @property string $phone
 * @property integer $status
 * @property integer $is_auto
 * @property string $contents
 * @property string $footer
 * @property string $send_code
 * @property string $send_return
 * @property integer $send_status
 * @property string $send_time
 * @property string $send_url
 * @property string $code
 * @property integer $code_status
 * @property string $code_time
 * @property string $addtime
 * @property string $addip
 * @property string $updatetime
 * @property integer $updateip
 */
class PhoneSmslog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_phone_smslog';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'nid' => 'Nid',
            'type' => 'Type',
            'phone' => 'Phone',
            'status' => 'Status',
            'is_auto' => 'Is Auto',
            'contents' => 'Contents',
            'footer' => 'Footer',
            'send_code' => 'Send Code',
            'send_return' => 'Send Return',
            'send_status' => 'Send Status',
            'send_time' => 'Send Time',
            'send_url' => 'Send Url',
            'code' => 'Code',
            'code_status' => 'Code Status',
            'code_time' => 'Code Time',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
            'updatetime' => 'Updatetime',
            'updateip' => 'Updateip',
        ];
    }
}
