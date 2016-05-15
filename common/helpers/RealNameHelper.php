<?php

namespace common\helpers;
use Yii;
use common\helpers\WebService;

class RealNameHelper{

    /*
     * 获取用户的实名认证信息
     */
    public static  function getUsrRealNameInfo($userid,$clientType){

        $data ['user_id'] = $userid;
        $data ['module'] = 'approve';
        $data ['q'] = 'get_realname_one';
        $data ['method'] = 'get';
        $userRealInfo['realname_result'] =  WebService::clientSoap($data,$clientType);
        return $userRealInfo;

    }

    /*
     * 验证身份证是否已验证
     * boolen  true 已认证 false 没有认证
     */

     public static function getCardId($cardId,$clientType){
        //验证身份证是否存在
        $check ['module'] = 'approve';
        $check ['q'] = 'check_realname_cardid';
        $check ['card_id'] = $cardId;
        $check ['method'] = 'get';
        $checkresult =  WebService::clientSoap($check,$clientType);
        if ($checkresult ['result'] == 'success') {
            return true;
        }
         return false;
    }

    /*
     * 判断用户是否已经实名认证
     * 返回值 boolen  true 已经实名认证  false 没有实名认证
     */

    public static function getUserRealNameStatus($userid,$clientType){
        $user_result = array (
            "module" => "dyp2p",
            "q" => "get_users",
            "user_id" =>$userid,
            "method" => "get"
        );
        $userResult =   WebService::clientSoap($user_result,$clientType);
        if($userResult ['approve_result']['realname_status']!=1){
            return false;
        }
        return true;


//        $_G ['user_result'] =  $userResult ['user_result'];
//        $_G ['message_result'] = $userResult ['message_result'];
//        $_G ['account_result'] = $userResult ['account_result'];
//        $_G ['approve_result'] = $userResult ['approve_result'];
//        $_G ['credit_result'] = $userResult ['credit_result'];

//        $realname = array(
//            'module'=>'approve'
//            ,'q'=>'check_realname'
//            ,'user_id'=>$_SESSION['user_id']
//            ,'status'=>''
//            ,'verify_userid'=>''
//            ,'verify_remark'=>1
//        );
//        $result = WebService::clientSoap($realname,Yii::$app->params['clientType']);

    }


}