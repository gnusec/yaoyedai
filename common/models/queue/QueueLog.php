<?php

namespace common\models\queue;

use Yii;
use yii\data\Pagination;
use common\helpers\RequestHelper;

/**
 * This is the model class for table "diyou_queue_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $voucher_type
 * @property string $voucher_money
 * @property integer $one_level_inviter_userid
 * @property string $one_level_voucher_money
 * @property integer $two_level_inviter_userid
 * @property string $two_level_voucher_money
 * @property integer $created_at
 * @property integer $updated_at
 */
class QueueLog extends \yii\db\ActiveRecord
{
    public $pagenum=5;
    public $count=0;
    public $nums=0;
    public $pagination;
    public $where='';
    public $list='';
    public $end_time;
    public $begin_time;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_queue_log';
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
            'voucher_type' => 'Voucher Type',
            'voucher_money' => 'Voucher Money',
            'one_level_inviter_userid' => 'One Level Inviter Userid',
            'one_level_voucher_money' => 'One Level Voucher Money',
            'two_level_inviter_userid' => 'Two Level Inviter Userid',
            'two_level_voucher_money' => 'Two Level Voucher Money',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public   function getFriendList(){
        $this->setwhere();

        $this->count= (new \yii\db\Query())
            ->from('diyou_queue_log p1')
            ->innerJoin('diyou_users p2', 'p1.user_id=p2.user_id')
            ->where('  '.$this->where)
            ->count();

        $this->pagination = new Pagination([
            'defaultPageSize' => $this->pagenum,
            'totalCount' => $this->count,
        ]);


        $this->list= (new \yii\db\Query())
            ->select(' p1.user_id,p1.one_level_inviter_userid,p1.two_level_inviter_userid,p1.one_level_voucher_money,p2.username')
            ->from('diyou_queue_log p1')
            ->innerJoin('diyou_users p2', 'p1.user_id=p2.user_id')
            ->where('  '.$this->where)
            ->orderBy('p1.created_at desc')
            ->offset( $this->pagination->offset)
            ->limit( $this->pagination->limit)
            ->all();


        if(!empty($this->list)){
            foreach($this->list as $key=>$val){
                $two = self::find()
                    ->where('two_level_inviter_userid='.Yii::$app->user->id.' and one_level_inviter_userid='.$val['user_id'])
                    ->one();
                if(!empty($two)){
                    $this->list[$key]['twolevel'] = $two['two_level_voucher_money'];
                }else{
                    $this->list[$key]['twolevel'] = 0;
                }
            }
        }

        return $this;

    }

    // 搜索条件
    public function setwhere(){

        $where = 'p1.one_level_inviter_userid='.Yii::$app->user->id;

        $beginTime = RequestHelper::get('begin_time');
        $endTime = RequestHelper::get('end_time');
        if(!empty($endTime) && !empty($beginTime)){
            $where.=' and created_at >'.strtotime($beginTime) .' and created_at<'.strtotime($endTime);
            $this->begin_time = $beginTime;
            $this->end_time = $endTime;
        }else if(!empty($beginTime)){
            $this->begin_time = $beginTime;
            $where.=' and created_at >'.strtotime($beginTime);
        }else if(!empty($endTime)){
            $this->end_time = $endTime;
            $where.=' and created_at<'.strtotime($endTime);
        }

        $this->where =$where;
    }

    //级奖励个数
    public static function Level($level){
        $beginTime = RequestHelper::get('begin_time');
        $endTime = RequestHelper::get('end_time');
        if(empty($level)){
            return false;
        }
        $levelWhere  = $level=='one_level' ? 'one_level_inviter_userid='.Yii::$app->user->id : 'two_level_inviter_userid='.Yii::$app->user->id;
        if(!empty($endTime) && !empty($beginTime)){
            $levelWhere.=' and created_at >'.strtotime($beginTime) .' and created_at<'.strtotime($endTime);

        }else if(!empty($beginTime)){

            $levelWhere.=' and created_at >'.strtotime($beginTime);
        }else if(!empty($endTime)){

            $levelWhere.=' and created_at<'.strtotime($endTime);
        }
        $nums = self::find()->where($levelWhere)->count();
        return $nums?$nums:0;
    }

    //获取好友投资记录

    public  function getFriendDeal(){

        $this->count= (new \yii\db\Query())
            ->from('diyou_users_friends_invite p1')
            ->leftJoin('diyou_users p2', 'p1.friends_userid=p2.user_id')
            ->innerJoin('diyou_borrow_tender p3', 'p1.friends_userid=p3.user_id')
            ->where('p1.user_id='.Yii::$app->user->id.' and p3.tender_status=1' )
            ->count();
        $this->pagenum = 10;
        $this->pagination = new Pagination([
            'defaultPageSize' => $this->pagenum,
            'totalCount' => $this->count,
        ]);

        $this->list= (new \yii\db\Query())
            ->select(' p1.*,p2.username,p3.account')
            ->from('diyou_users_friends_invite p1')
            ->leftJoin('diyou_users p2', 'p1.friends_userid=p2.user_id')
            ->innerJoin('diyou_borrow_tender p3', 'p1.friends_userid=p3.user_id')
            ->where('p1.user_id='.Yii::$app->user->id.' and p3.tender_status=1' )
            ->offset( $this->pagination->offset)
            ->limit( $this->pagination->limit)
            ->all();

        return $this;

    }

}
