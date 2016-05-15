<?php

namespace common\models\remind;

use Yii;

/**
 * This is the model class for table "diyou_phone".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $phone
 * @property string $addtime
 * @property string $updatetime
 */
class Phone extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_phone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'phone', 'addtime', 'updatetime'], 'required'],
            [['user_id'], 'integer'],
            [['phone'], 'string', 'max' => 20],
            [['addtime', 'updatetime'], 'string', 'max' => 30],
            [['user_id'], 'unique'],
            [['phone'], 'unique']
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
            'phone' => 'Phone',
            'addtime' => 'Addtime',
            'updatetime' => 'Updatetime',
        ];
    }
}
