<?php

namespace common\models\borrowtender;

use Yii;

/**
 * This is the model class for table "diyou_borrow_tender".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $status
 * @property string $borrow_nid
 * @property string $nid
 * @property string $account_tender
 * @property string $account
 * @property integer $change_status
 * @property integer $change_userid
 * @property integer $change_period
 * @property integer $tender_status
 * @property string $tender_nid
 * @property string $tender_award_account
 * @property integer $recover_full_status
 * @property string $recover_fee
 * @property string $recover_type
 * @property string $recover_account_all
 * @property string $recover_account_interest
 * @property string $recover_account_yes
 * @property string $recover_account_interest_yes
 * @property string $recover_account_capital_yes
 * @property string $recover_account_wait
 * @property string $recover_account_interest_wait
 * @property string $recover_account_capital_wait
 * @property integer $recover_times
 * @property string $recover_advance_fee
 * @property string $recover_late_fee
 * @property string $tender_award_fee
 * @property string $contents
 * @property integer $auto_status
 * @property integer $web_status
 * @property string $ordid
 * @property integer $orddate
 * @property string $frostaccountid
 * @property string $SubOrdId
 * @property string $SubOrdDate
 * @property string $addtime
 * @property string $addip
 * @property string $vouchers
 * @property string $youxuan_nid
 */
class BorrowTender extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_borrow_tender';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'change_status', 'change_userid', 'change_period', 'tender_status', 'recover_full_status', 'recover_times', 'auto_status', 'web_status', 'orddate'], 'integer'],
            [['nid', 'change_status', 'change_userid', 'change_period', 'tender_status', 'tender_nid', 'tender_award_account', 'recover_full_status', 'recover_fee', 'recover_type', 'recover_advance_fee', 'recover_late_fee', 'tender_award_fee', 'contents', 'web_status', 'ordid', 'orddate', 'frostaccountid', 'SubOrdId', 'SubOrdDate', 'vouchers'], 'required'],
            [['account_tender', 'account', 'tender_award_account', 'recover_fee', 'recover_account_all', 'recover_account_interest', 'recover_account_yes', 'recover_account_interest_yes', 'recover_account_capital_yes', 'recover_account_wait', 'recover_account_interest_wait', 'recover_account_capital_wait', 'recover_advance_fee', 'recover_late_fee', 'tender_award_fee'], 'number'],
            [['borrow_nid', 'tender_nid', 'ordid', 'frostaccountid', 'addtime', 'addip', 'youxuan_nid'], 'string', 'max' => 50],
            [['nid', 'recover_type'], 'string', 'max' => 100],
            [['contents'], 'string', 'max' => 250],
            [['SubOrdId'], 'string', 'max' => 30],
            [['SubOrdDate'], 'string', 'max' => 20],
            [['vouchers'], 'string', 'max' => 255],
            [['nid'], 'unique']
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
            'status' => 'Status',
            'borrow_nid' => 'Borrow Nid',
            'nid' => 'Nid',
            'account_tender' => 'Account Tender',
            'account' => 'Account',
            'change_status' => 'Change Status',
            'change_userid' => 'Change Userid',
            'change_period' => 'Change Period',
            'tender_status' => 'Tender Status',
            'tender_nid' => 'Tender Nid',
            'tender_award_account' => 'Tender Award Account',
            'recover_full_status' => 'Recover Full Status',
            'recover_fee' => 'Recover Fee',
            'recover_type' => 'Recover Type',
            'recover_account_all' => 'Recover Account All',
            'recover_account_interest' => 'Recover Account Interest',
            'recover_account_yes' => 'Recover Account Yes',
            'recover_account_interest_yes' => 'Recover Account Interest Yes',
            'recover_account_capital_yes' => 'Recover Account Capital Yes',
            'recover_account_wait' => 'Recover Account Wait',
            'recover_account_interest_wait' => 'Recover Account Interest Wait',
            'recover_account_capital_wait' => 'Recover Account Capital Wait',
            'recover_times' => 'Recover Times',
            'recover_advance_fee' => 'Recover Advance Fee',
            'recover_late_fee' => 'Recover Late Fee',
            'tender_award_fee' => 'Tender Award Fee',
            'contents' => 'Contents',
            'auto_status' => 'Auto Status',
            'web_status' => 'Web Status',
            'ordid' => 'Ordid',
            'orddate' => 'Orddate',
            'frostaccountid' => 'Frostaccountid',
            'SubOrdId' => 'Sub Ord ID',
            'SubOrdDate' => 'Sub Ord Date',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
            'vouchers' => 'Vouchers',
            'youxuan_nid' => 'Youxuan Nid',
        ];
    }
}
