<?php

namespace common\helpers;
use Yii;
use common\helpers\identity\smsInterface;
use common\helpers\RequestHelper;
use common\models\remind\PhonePort;
use common\models\remind\Remind;
use common\models\user\Diyouuser;
use common\models\remind\PhoneSmslog;
use \yii\base\Exception;
use common\models\remind\Phone;
use \common\log\LogUtil;


class DefaultSmsPort  implements  smsInterface{

    public $nid = 'tender_vouchers_sucess';
    public $smsPort = 3;
    /*
     * 发送短信方法
     */
    public  function sendsms($user_id,$active=null){

        $phone_port = $this->GetSendPort($this->smsPort);

        try{
            if($user_id<0){
                throw new Exception('发送短信失败：错误的参数user_id');
            }

            if(!$phone_port){
                throw new Exception('发送短信失败：未配置短信接口信息！');
            }

            if($phone_port['sendnow']!=1){
                throw new Exception('发送短信失败：短信接口配置项为不是立即发送:用户id='.$user_id);
            }

            if(!$this->getUserPhone($user_id)){
                throw new Exception('发送短信失败：用户未实名认证:用户id='.$user_id);
            }

            $sendinfo = Remind::find()->where('nid=:nid',[':nid'=>$this->nid])->one();
            //取出要发送的短信内容
            if(!$sendinfo){
                throw new Exception('未配置投资赠送代金券配置项！');
            }

            if ($phone_port['utf_status']==1){
                // xzy 首先判断是否已经是utf-8编码如果是就不转换 2014-09-26
                if(mb_check_encoding($sendinfo['message_contents'], 'UTF-8') == false){
                    $sendinfo['message_contents'] = iconv("GBK", "UTF-8",$sendinfo['message_contents']);
                }
            }

            //添加尾部附加文本
            if(!empty($phone_port['content_add_text']) &&
                strstr($sendinfo['message_contents'],$phone_port['content_add_text']) == FALSE){
                $sendinfo['message_contents'] = $sendinfo['message_contents'].'【'.$phone_port['content_add_text'].'】';
            }

            $sendinfo['message_contents'] = sprintf($sendinfo['message_contents'],$this->getUserInfo($user_id)['username'],$active->money,date('Y-m-d',$active->end_time));

            $nid = $this->nid.'_'.$user_id.'_'.time();
            $_result = PhoneSmslog::find()->where('nid=:nid',[':nid'=>$nid])->one();
            if ($_result){
                $result = PhoneSmslog::updateAll([ 'updatetime'=>time() ],['nid'=>$nid]);
                $log_id =  $_result['id'];
            }else{
                $data['updatetime'] = time();
                $PhoneSmslog = new PhoneSmslog();
                $PhoneSmslog->nid = $nid;
                $PhoneSmslog->user_id = $user_id;
                $PhoneSmslog->phone = $this->getUserPhone($user_id)['phone'];
                $PhoneSmslog->contents = $sendinfo['message_contents'];
                $PhoneSmslog->type = $this->nid;
                $PhoneSmslog->status = 0;

                if(!$PhoneSmslog->save()){
                    throw new Exception('投资赠送代金券发送短信失败！插入日志记录失败');
                }else{
                    $log_id =  $PhoneSmslog->attributes['id'];
                }
            }

            $_sms_url = explode("?",$phone_port['url']);
            $http = $_sms_url[0];
            $_sms_url[1] = str_replace("#phone#",$this->getUserPhone($user_id)['phone'],$_sms_url[1]);
            $_sms_url[1] = str_replace("#message#", $sendinfo['message_contents'] ,$_sms_url[1] );
            $_sms_url[1] = str_replace("#content#", $sendinfo['message_contents'] ,$_sms_url[1] );
            $_sms_url[1] = str_replace("&amp;","&",$_sms_url[1]);
            $__data = explode("&",$_sms_url[1]);

            $_res = array();
            foreach ($__data as $key => $value){
                $_val = explode("=",$value);
                $_res[$_val[0]] = $_val[1];
            }

            if ($phone_port['type']=="get"){
                $result = RequestHelper::doGet($http."?".$_sms_url[1]); //url方式提交
            }else{
                $result= RequestHelper::doPost($http,$_res); //POST方式提交
            }

            if ($phone_port['res_k']!=""){
                $result = $result[$phone_port['res_k']];
            }

            if ($phone_port['res_v']!=""){
                $val = $phone_port['res_v'];
            }else{
                $val = 1;
            }

            if( strstr($result,'<error>0</error>') != FALSE ){

                $result = PhoneSmslog::updateAll([ 'status'=>1,'send_url'=>$phone_port['url'],'send_time'=>time(),'contents'=>$sendinfo['message_contents'] ],['id'=>$log_id]);

                return true;


            }

            return false;

        }catch(\Exception  $ex){
            LogUtil::log($ex->getMessage(),'sendsms.log');
        }

        return false;
    }


    //获取默认短信接口
    private  function GetSendPort($id=0){

        if ($id>0){
            $result = PhonePort::find()->where('id=:id',[':id'=>$id])->one();
            if ($result){
                return $result;
            }
        }

        $result = PhonePort::find()->where('default_status=:default_status',[':default_status'=>1])->one();
        if ($result){
            return $result;
        }

        $result = PhonePort::find()->where('status=:status',[':status'=>1])->orderBy( RAND() )->one();
        if ($result){
            return $result;
        }

        return false;
    }


    private function getUserPhone($userid){
        if($userid<0){
            return false;
        }

        $res = Phone::find()->where('user_id=:user_id',[':user_id'=>$userid])->one();

        return $res ? $res : false;
    }

    private function getUserInfo($userid){
        if($userid<0){
            return false;
        }

        $res = Diyouuser::find()->where('user_id=:user_id',[':user_id'=>$userid])->one();

        return $res ? $res : false;
    }



    public  function sendemail(){

    }





}