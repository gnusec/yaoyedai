<?php

namespace common\models\vouchers;

use Yii;

/**
 * This is the model class for table "diyou_vouchers_type".
 *
 * @property string $type_id
 * @property string $name
 * @property string $status
 * @property string $money
 * @property string $start_time
 * @property string $end_time
 * @property string $effect_time
 * @property string $save_time
 * @property string $single_quota
 * @property string $total_quota
 * @property string $one_inviter_money
 * @property string $two_inviter_money
 */
class VouchTypes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_vouchers_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['money', 'single_quota', 'total_quota', 'one_inviter_money', 'two_inviter_money'], 'number'],
            [['start_time', 'end_time', 'effect_time'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['start_time', 'end_time', 'effect_time', 'save_time'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id' => 'Type ID',
            'name' => 'Name',
            'status' => 'Status',
            'money' => 'Money',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'effect_time' => 'Effect Time',
            'save_time' => 'Save Time',
            'single_quota' => 'Single Quota',
            'total_quota' => 'Total Quota',
            'one_inviter_money' => 'One Inviter Money',
            'two_inviter_money' => 'Two Inviter Money',
        ];
    }
}
