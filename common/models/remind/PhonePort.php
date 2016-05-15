<?php

namespace common\models\remind;

use Yii;

/**
 * This is the model class for table "diyou_phone_port".
 *
 * @property integer $id
 * @property string $title
 * @property string $url
 * @property string $type
 * @property integer $default_status
 * @property integer $status
 * @property integer $send_total
 * @property integer $sendnow
 * @property integer $utf_status
 * @property string $res_k
 * @property string $res_v
 * @property string $content_add_text
 * @property string $remark
 */
class PhonePort extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_phone_port';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'url', 'type', 'default_status', 'status', 'send_total', 'sendnow', 'utf_status', 'res_k', 'res_v', 'content_add_text', 'remark'], 'required'],
            [['default_status', 'status', 'send_total', 'sendnow', 'utf_status'], 'integer'],
            [['content_add_text'], 'string'],
            [['title', 'url', 'remark'], 'string', 'max' => 200],
            [['type'], 'string', 'max' => 20],
            [['res_k', 'res_v'], 'string', 'max' => 100]
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
            'url' => 'Url',
            'type' => 'Type',
            'default_status' => 'Default Status',
            'status' => 'Status',
            'send_total' => 'Send Total',
            'sendnow' => 'Sendnow',
            'utf_status' => 'Utf Status',
            'res_k' => 'Res K',
            'res_v' => 'Res V',
            'content_add_text' => 'Content Add Text',
            'remark' => 'Remark',
        ];
    }
}
