<?php

namespace common\models\vouchers;

use Yii;

/**
 * This is the model class for table "diyou_vouchers_log".
 *
 * @property integer $id
 * @property integer $type_id
 * @property string $serial
 * @property integer $invite_userid
 * @property integer $verify_userid
 * @property integer $verify_time
 * @property string $verify_remark
 * @property integer $verify_status
 * @property string $vouchers_account
 * @property integer $user_id
 * @property string $start_time
 * @property string $end_time
 * @property string $effect_time
 * @property integer $add_time
 * @property integer $update_time
 * @property integer $is_use
 * @property integer $use_time
 * @property string $accrual
 * @property integer $accrual_time
 * @property string $tender_id
 */
class VouchersLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_vouchers_log';
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
            'type_id' => 'Type ID',
            'serial' => 'Serial',
            'invite_userid' => 'Invite Userid',
            'verify_userid' => 'Verify Userid',
            'verify_time' => 'Verify Time',
            'verify_remark' => 'Verify Remark',
            'verify_status' => 'Verify Status',
            'vouchers_account' => 'Vouchers Account',
            'user_id' => 'User ID',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'effect_time' => 'Effect Time',
            'add_time' => 'Add Time',
            'update_time' => 'Update Time',
            'is_use' => 'Is Use',
            'use_time' => 'Use Time',
            'accrual' => 'Accrual',
            'accrual_time' => 'Accrual Time',
            'tender_id' => 'Tender ID',
        ];
    }
}
