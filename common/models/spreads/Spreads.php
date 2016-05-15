<?php

namespace common\models\spreads;

use Yii;
use yii\data\Pagination;
use common\helpers\RequestHelper;
/**
 * This is the model class for table "diyou_spreads_users".
 *
 * @property string $id
 * @property integer $user_id
 * @property integer $spreads_userid
 * @property string $set
 * @property string $type
 * @property string $addtime
 * @property string $addip
 */
class Spreads extends \yii\db\ActiveRecord
{
    public $pagenum=5;
    public $count=0;
    public $nums=0;
    public $pagination;
    public $where='';
    public $list='';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'diyou_spreads_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'spreads_userid', 'set', 'type', 'addtime', 'addip'], 'required'],
            [['user_id', 'spreads_userid'], 'integer'],
            [['set'], 'string'],
            [['type', 'addtime', 'addip'], 'string', 'max' => 100],
            [['user_id'], 'unique']
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
            'spreads_userid' => 'Spreads Userid',
            'set' => 'Set',
            'type' => 'Type',
            'addtime' => 'Addtime',
            'addip' => 'Addip',
        ];
    }

    public   function getFriendList(){
        $this->setwhere();

        $this->count= (new \yii\db\Query())
            ->from('diyou_users p1')
            ->leftJoin('diyou_spreads_users p2', 'p1.user_id=p2.user_id')
            ->leftJoin('diyou_users p3', 'p2.spreads_userid=p3.user_id')
            ->where('  '.$this->where)
            ->count();

        $this->pagination = new Pagination([
            'defaultPageSize' => $this->pagenum,
            'totalCount' => $this->count,
        ]);


        $this->list= (new \yii\db\Query())
            ->select(' p1.*,p2.spreads_userid,p2.type as spreads_type,p2.addtime,p3.username as spreads_username ')
            ->from('diyou_users p1')
            ->leftJoin('diyou_spreads_users p2', 'p1.user_id=p2.user_id')
            ->leftJoin('diyou_users p3', 'p2.spreads_userid=p3.user_id')
            ->where('  '.$this->where)
            ->orderBy('p1.user_id desc')
            ->offset( $this->pagination->offset)
            ->limit( $this->pagination->limit)
            ->all();

        return $this;
    }

    // 搜索条件
    public function setwhere(){
        $where = '  p1.user_id  in (select user_id from `diyou_spreads_users`) and p2.spreads_userid>0 and p2.spreads_userid=2 ';

        $beginTime = RequestHelper::get('begin_time');
        $endTime = RequestHelper::get('end_time');
        if(!empty($endTime) && !empty($beginTime)){
            $where.=' and p2.addtime >'.strtotime($beginTime) .' and p2.addtime<'.strtotime($endTime);
        }else if(!empty($beginTime)){
            $where.=' and p2.addtime >'.strtotime($beginTime);
        }else if(!empty($endTime)){
            $where.=' and p2.addtime<'.strtotime($endTime);
        }

        $this->where =$where;
    }



}
