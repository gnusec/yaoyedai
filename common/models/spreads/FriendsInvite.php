<?php

namespace common\models\spreads;

use Yii;

/**
 * This is the model class for table "diyou_users_friends_invite".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $friends_userid
 * @property integer $status
 * @property integer $type
 * @property string $content
 * @property integer $credit
 * @property string $addtime
 * @property string $addip
 */
class FriendsInvite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_users_friends_invite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'friends_userid', 'status', 'type', 'credit'], 'integer'],
            [['credit'], 'required'],
            [['content'], 'string', 'max' => 250],
            [['addtime', 'addip'], 'string', 'max' => 50]
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
            'friends_userid' => 'Friends Userid',
            'status' => 'Status',
            'type' => 'Type',
            'content' => 'Content',
            'credit' => 'Credit',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
        ];
    }
}
