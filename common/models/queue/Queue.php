<?php

namespace common\models\queue;

use Yii;

/**
 * This is the model class for table "diyou_queue".
 *
 * @property integer $id
 * @property integer $act_type
 * @property integer $total_status
 * @property integer $single_status
 * @property string $money
 * @property integer $create_at
 * @property integer $update_at
 * @property string $borrow_type
 * @property integer $tender_time
 * @property string $tender_nid
 * @property string $borrow_nid
 * @property integer $user_id
 */
class Queue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_queue';
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
            'act_type' => 'Act Type',
            'total_status' => 'Total Status',
            'single_status' => 'Single Status',
            'money' => 'Money',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'borrow_type' => 'Borrow Type',
            'tender_time' => 'Tender Time',
            'tender_nid' => 'Tender Nid',
            'borrow_nid' => 'Borrow Nid',
            'user_id' => 'User ID',
        ];
    }
}
