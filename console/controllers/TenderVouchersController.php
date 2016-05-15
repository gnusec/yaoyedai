<?php

namespace console\controllers;
use common\models\vouchers\VouchTypes;
use common\models\vouchers\VouchersLog;
use common\models\borrowtender\BorrowTender;
use common\models\queue\Queue;
use common\models\queue\QueueLog;
use common\helpers\RemindHelper;
use common\models\spreads\FriendsInvite;
use common\log\LogUtil;
use \yii\base\Exception;
class TenderVouchersController extends \yii\web\Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;
    const ACT_NAME = '投资代金券';
    const QUEUE_TYPE = 10;//类型10=>投资 20=>提现
    const VOUCHER_SINGLE = 10;//单笔
    const VOUCHER_TOTAL = 20;//总额

    /*
     * 统计投资会员赠送代金券
     * 根据投资记录表按照投资时间做增量统计，避免重复统计数据，将统计出来的数据先入库
     */
    public function actionIndex()
    {
        //配置读库链接 todo

        //取活动信息
        $activeInfo = VouchTypes::find()
                        ->where('status=:status and name=:name and start_time<=:start_time and end_time>=:end_time',[
                             ':status'=>1,
                             ':name'=>self::ACT_NAME,
                             ':start_time'=>time(),
                             ':end_time'=>time()
                            ])
                        ->asArray()
                        ->one();

        //获取已开启并且在进行中
        if(!empty($activeInfo)){
            //先从queue表中取最后一条记录的create_at做增量
            $lastTender = Queue::find()
                                ->where('create_at>=:begin_time and create_at<=:end_time and act_type=:act_type',[
                                    ':act_type'=>self::QUEUE_TYPE,
                                    ':begin_time'=>$activeInfo['start_time'],
                                    ':end_time'=>$activeInfo['end_time']
                                ])
                                ->asArray()
                                ->orderBy('create_at desc')
                                ->one();

            $beginTime = $activeInfo['start_time'];
            if(!empty($lastTender)){
                $beginTime = $lastTender['create_at'];
            }

            //开始统计数据inner diyou_borrow 表

            $list= (new \yii\db\Query())
                ->select('p1.account_tender,p1.user_id,p1.borrow_nid,p1.nid,p1.addtime,p2.borrow_type')
                ->from('diyou_borrow_tender p1')
                ->innerJoin('diyou_borrow p2', 'p1.borrow_nid=p2.borrow_nid')
                ->where('p1.tender_status=:tender_status and p1.addtime>=:begintime and p1.addtime<=:endtime',[
                    ':tender_status'=>1,//复审通过变为1
                    ':begintime'=>$beginTime,
                    ':endtime'=>$activeInfo['end_time']
                ])
                ->all();
            //var_dump($list);exit;
            //有投资数据写入数据
            if(!empty($list)){
                foreach($list as $key=>$val){
                    //判断标类型过滤代金券标
                    if($val['borrow_type'] == 'welfare'){
                        continue;
                    }
                    //保存数据
                    $queue = new Queue();
                    $queue->act_type = self::QUEUE_TYPE;
                    $queue->total_status = 0;
                    $queue->single_status = 0;
                    $queue->money = $val['account_tender'];
                    $queue->create_at = time();
                    $queue->update_at = time();
                    $queue->borrow_type = $val['borrow_type'];
                    $queue->tender_time = $val['addtime'];
                    $queue->tender_nid = $val['nid'];
                    $queue->borrow_nid = $val['borrow_nid'];
                    $queue->user_id = $val['user_id'];

                    if(!$queue->save()){
                        //添加失败写入日志
                        LogUtil::log($queue->getErrors(),'TenderVouchers.log');
                    }
                }
            }

        }

    }



    /*
     * 取数据赠送代金券
     */

    public function actionSendVouchers(){

        //取出未发送代金券列表
        $sendList = Queue::find()->where('single_status=:single_status || total_status=:total_status',[
            ':single_status'=>0,
            ':total_status'=>0
        ])->orderBy('id desc')->all();

        try{

            if(!empty($sendList) && is_array($sendList)){
                //取出配置项
                $activeInfo = VouchTypes::find()
                    ->where('status=:status and name=:name and start_time<=:start_time and end_time>=:end_time',[
                        ':status'=>1,
                        ':name'=>self::ACT_NAME,
                        ':start_time'=>time(),
                        ':end_time'=>time()
                    ])
                    ->one();

                if(empty($activeInfo)){
                    throw new Exception('活动已经结束，但还有未发送完成的用户，用户数据:'.var_export($sendList,true));
                }
                //循环发送代金券
                foreach($sendList as $key=>$val){

                    //按单笔投资金额送
                    if($val['money']>=$activeInfo['single_quota'] && intval($activeInfo['single_quota'])!=0){

                        //单笔赠送规则活动期间内多笔满足值赠送一次
                        if(!$this->isSendSingle($val['user_id'],$activeInfo,self::VOUCHER_SINGLE)){

                            $VouchersLog = new VouchersLog();
                            $VouchersLog->user_id = $val['user_id'];
                            $VouchersLog->add_time = time();
                            $VouchersLog->serial = $this->CreateSerial($activeInfo['money']);
                            $VouchersLog->type_id = $activeInfo['type_id'];
                            $VouchersLog->vouchers_account = $activeInfo['money'];
                            $VouchersLog->start_time = $activeInfo['start_time'];
                            $VouchersLog->end_time = $activeInfo['end_time'];
                            $VouchersLog->effect_time = $activeInfo['effect_time'];
                            $VouchersLog->is_use = 0;

                            if($VouchersLog->save()){
                                //更新状态发送短信
                                $result = Queue::updateAll([ 'single_status'=>10],['id'=>$val['id']]);
                                if(!$result){
                                    //更新数据失败
                                    LogUtil::log('赠送代金券成功但是更新数据失败，用户id为：'.$val['user_id'],'SendTenderVouchers.log');
                                }
                                //发送短信
                                $sms = RemindHelper::getSmsIndentity('Default');
                                $sms->sendsms($val['user_id'],$activeInfo);
                                //给邀请人 赠送代金券闭包回调回来
                                $this->ToSendInviter($val['user_id'],$activeInfo,function($retDate) use ( $val,$activeInfo ){

                                    $QueueLog = new QueueLog();
                                    $QueueLog->user_id = $val['user_id'];
                                    $QueueLog->voucher_money = $activeInfo['money'];
                                    $QueueLog->voucher_type = self::VOUCHER_SINGLE;
                                    $QueueLog->one_level_inviter_userid = isset($retDate['one_level_inviter_userid']) ? $retDate['one_level_inviter_userid'] : '';
                                    $QueueLog->one_level_voucher_money = isset($retDate['one_level_voucher_money'])?$retDate['one_level_voucher_money']:'';
                                    $QueueLog->two_level_inviter_userid = isset($retDate['two_level_inviter_userid'])?$retDate['two_level_inviter_userid']:'';
                                    $QueueLog->two_level_voucher_money = isset($retDate['two_level_voucher_money'])?$retDate['two_level_voucher_money'] : '';
                                    $QueueLog->created_at = time();
                                    $QueueLog->updated_at = time();
                                    if(!$QueueLog->save()){
                                        LogUtil::log('单笔投资金额失败','SendTenderVouchers.log');
                                    }

                                });

                            }else{
                                //添加失败写入日志
                                LogUtil::log(var_export($VouchersLog->getErrors(),true),'SendTenderVouchers.log');
                            }
                        }

                    }else{
                        LogUtil::log('该投资用户id:'.$val['user_id'].'该笔投资金额'.$val['money'].'元，未发放代金券，原因：未满足单笔投资金额:'.$activeInfo['single_quota'],'NoSendTenderVouchersList.log');
                    }

                    //按活期期间内投资总额送
                    if(!$this->isSendSingle($val['user_id'],$activeInfo,self::VOUCHER_TOTAL)){
                        $totalMoney = Queue::find()->where('user_id=:user_id and create_at>=:begin_time and create_at<=:end_time',[
                            ':user_id'=>$val['user_id'],
                            ':begin_time'=>$activeInfo['start_time'],
                            ':end_time'=>$activeInfo['end_time']
                        ])->sum('money');

                        if($totalMoney>=$activeInfo['total_quota'] && intval($activeInfo['total_quota'])!=0){

                            $TotalQuotaVouchersLog = new VouchersLog();
                            $TotalQuotaVouchersLog->user_id = $val['user_id'];

                            $TotalQuotaVouchersLog->add_time = time();
                            $TotalQuotaVouchersLog->serial = $this->CreateSerial($activeInfo['money']);
                            $TotalQuotaVouchersLog->type_id = $activeInfo['type_id'];
                            $TotalQuotaVouchersLog->vouchers_account = $activeInfo['money'];
                            $TotalQuotaVouchersLog->start_time = $activeInfo['start_time'];
                            $TotalQuotaVouchersLog->end_time = $activeInfo['end_time'];
                            $TotalQuotaVouchersLog->effect_time = $activeInfo['effect_time'];
                            $TotalQuotaVouchersLog->is_use = 0;

                            if($TotalQuotaVouchersLog->save()){

                                //更新状态发送短信
                                $result = Queue::updateAll([ 'total_status'=>10],['id'=>$val['id']]);
                                if(!$result){
                                    //更新数据失败
                                    LogUtil::log('赠送代金券成功但是更新数据失败，用户id为：'.$val['user_id'],'SendTenderVouchers.log');
                                }
                                $sms = RemindHelper::getSmsIndentity('Default');
                                $sms->sendsms($val['user_id'],$activeInfo);

                                //给邀请人 赠送代金券闭包回调回来
                                $this->ToSendInviter($val['user_id'],$activeInfo,function($retDate) use ( $val,$activeInfo ){

                                    $QueueLog = new QueueLog();
                                    $QueueLog->user_id = $val['user_id'];
                                    $QueueLog->voucher_money = $activeInfo['money'];
                                    $QueueLog->voucher_type = self::VOUCHER_TOTAL;
                                    $QueueLog->one_level_inviter_userid = isset($retDate['one_level_inviter_userid']) ? $retDate['one_level_inviter_userid'] : '';
                                    $QueueLog->one_level_voucher_money = isset($retDate['one_level_voucher_money'])?$retDate['one_level_voucher_money']:'';
                                    $QueueLog->two_level_inviter_userid = isset($retDate['two_level_inviter_userid'])?$retDate['two_level_inviter_userid']:'';
                                    $QueueLog->two_level_voucher_money = isset($retDate['two_level_voucher_money'])?$retDate['two_level_voucher_money'] : '';
                                    $QueueLog->created_at = time();
                                    $QueueLog->updated_at = time();
                                    if(!$QueueLog->save()){
                                        LogUtil::log('投资总额失败','SendTenderVouchers.log');
                                    }

                                });


                            }else{
                                //添加失败写入日志
                                LogUtil::log(var_export($TotalQuotaVouchersLog->getErrors(),true),'SendTenderVouchers.log');
                            }

                        }else{
                            LogUtil::log('该投资用户id:'.$val['user_id'].'投资总金额'.$totalMoney.'元，未发放代金券，原因：未满足投资总金额:'.$activeInfo['total_quota'],'NoSendTenderVouchersList.log');
                        }
                    }

                }

            }

        }catch(\Exception  $ex){
            LogUtil::log($ex->getMessage(),'SendTenderVouchers.log');
        }


    }


    /*
     * 活动范围内是否已经有过单笔奖励
     */

    private  function isSendSingle($user_id,VouchTypes $active,$type){

        $one = QueueLog::find()->where('user_id=:user_id and voucher_type=:voucher_type and created_at>=:begin_time and created_at<=:end_time',[
            ':user_id'=>$user_id,
            ':voucher_type'=>$type,
            ':begin_time'=>$active->start_time,
            ':end_time'=>$active->end_time
        ])->one();

        return $one?true:false;

    }


    /*
     * 给邀请人发送代金券
     */

    private function ToSendInviter($user_id,VouchTypes $active,$function){
        $insert = [];
        //查出邀请人
        $inviter = $this->GetInviterUserid($user_id);
        if(!empty($inviter)){

            //是否给一级邀请人送
            if(intval($active['one_inviter_money']) >0){
                    $myinviter = $this->GetInviterUserid($inviter['user_id']);
                    $VouchersLogInviter = new VouchersLog();
                    $VouchersLogInviter->user_id = $inviter['user_id'];
                    $VouchersLogInviter->invite_userid = (!empty($myinviter))?$myinviter['user_id']:0;//邀请人
                    $VouchersLogInviter->add_time = time();
                    $VouchersLogInviter->serial = $this->CreateSerial($active->one_inviter_money);
                    $VouchersLogInviter->type_id = $active->type_id;
                    $VouchersLogInviter->vouchers_account = $active->one_inviter_money;
                    $VouchersLogInviter->start_time = $active->start_time;
                    $VouchersLogInviter->end_time = $active->end_time;
                    $VouchersLogInviter->effect_time = $active->effect_time;
                    $VouchersLogInviter->is_use = 0;
                    if($VouchersLogInviter->save()){
                        //一级邀请插入字段
                        $insert =array_merge($insert,[
                            'one_level_inviter_userid'=>$inviter['user_id'],
                            'one_level_voucher_money'=>$active->one_inviter_money,
                        ]) ;
                        $sms = RemindHelper::getSmsIndentity('Default');
                        $sms->sendsms($inviter['user_id'],$active);
                    }else{
                        //给邀请人赠送代金券失败
                        LogUtil::log(var_export($VouchersLogInviter->getErrors(),true),'SendTenderVouchers.log');
                    }

            }

            //是否给二级邀请人送
            if(intval($active['two_inviter_money']) >0){
                //查出二级邀请人
                $twoinviter = $this->GetInviterUserid($inviter['user_id']);
                if(!empty($twoinviter)){
                    $myinviter = $this->GetInviterUserid($twoinviter['user_id']);
                    $VouchersLogInviterTwo = new VouchersLog();
                    $VouchersLogInviterTwo->user_id = $twoinviter['user_id'];
                    $VouchersLogInviterTwo->invite_userid = (!empty($myinviter))?$myinviter['user_id']:0;//邀请人
                    $VouchersLogInviterTwo->add_time = time();
                    $VouchersLogInviterTwo->serial = $this->CreateSerial($active->two_inviter_money);
                    $VouchersLogInviterTwo->type_id = $active->type_id;
                    $VouchersLogInviterTwo->vouchers_account = $active->two_inviter_money;
                    $VouchersLogInviterTwo->start_time = $active->start_time;
                    $VouchersLogInviterTwo->end_time = $active->end_time;
                    $VouchersLogInviterTwo->effect_time = $active->effect_time;
                    $VouchersLogInviterTwo->is_use = 0;
                    if($VouchersLogInviterTwo->save()){
                        //二级邀请插入字段
                        $insert = array_merge($insert,[
                            'two_level_inviter_userid'=>$twoinviter['user_id'],
                            'two_level_voucher_money'=>$active->two_inviter_money,
                        ]);

                        $sms = RemindHelper::getSmsIndentity('Default');
                        $sms->sendsms($twoinviter['user_id'],$active);
                    }else{
                        //给邀请人赠送代金券失败
                        LogUtil::log(var_export($VouchersLogInviterTwo->getErrors(),true),'SendTenderVouchers.log');
                    }
                }
            }

        }

        //回调
        if ($function instanceof \Closure) {
            $function($insert);
        }


    }





    /*
     * 获取用户的邀请人id
     */

    private function GetInviterUserid($user_id){
        //查出邀请人
        $inviter = FriendsInvite::find()->where('friends_userid=:friends_userid',[
            ':friends_userid'=>$user_id
        ])->one();

        return (!empty($inviter)) ? $inviter : null;
    }

    /*生成代金卷序列号*/
    private  function CreateSerial($account = ''){
        $num = 100;
        for($i=1;$i<$num;$i++){
            $today = 'DJJ'.date("ymdh").rand(1000,9999).$i;
            $r = $this->SerialPrevent($today);
            if($r==0){
                $serial=$today;
                break;
            }
        }

        return $serial;
    }


    //防系列号重复
    private function SerialPrevent($data){
        $result = VouchersLog::find()->where('serial=:serial',[
            ':serial'=>$data
        ])->asArray()->one();
        if($result){
            return 1;
        }else{
            return 0;
        }
    }

}
