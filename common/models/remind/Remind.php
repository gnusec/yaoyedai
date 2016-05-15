<?php

namespace common\models\remind;

use Yii;

/**
 * This is the model class for table "diyou_remind".
 *
 * @property integer $id
 * @property string $title
 * @property string $nid
 * @property integer $status
 * @property integer $order
 * @property integer $type_id
 * @property integer $message
 * @property integer $email
 * @property integer $phone
 * @property string $message_contents
 * @property string $email_contents
 * @property string $phone_contents
 * @property integer $addtime
 * @property string $addip
 */
class Remind extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_remind';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'order', 'type_id', 'message', 'email', 'phone', 'addtime'], 'integer'],
            [['message_contents', 'email_contents', 'phone_contents'], 'required'],
            [['message_contents', 'email_contents'], 'string'],
            [['title', 'nid'], 'string', 'max' => 50],
            [['phone_contents'], 'string', 'max' => 250],
            [['addip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'nid' => 'Nid',
            'status' => 'Status',
            'order' => 'Order',
            'type_id' => 'Type ID',
            'message' => 'Message',
            'email' => 'Email',
            'phone' => 'Phone',
            'message_contents' => 'Message Contents',
            'email_contents' => 'Email Contents',
            'phone_contents' => 'Phone Contents',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
        ];
    }
}
