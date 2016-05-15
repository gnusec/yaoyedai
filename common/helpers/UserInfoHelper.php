<?php

namespace common\helpers;
use Yii;
use common\helpers\WebService;

class UserInfoHelper{

    /*
     * 用户资金信息
     * 返回值 array
     */

    public static function getUserInfo($userid,$clientType){
        $user_result = array (
            "module" => "dyp2p",
            "q" => "get_users",
            "user_id" =>$userid,
            "method" => "get"
        );
        $userResult =   WebService::clientSoap($user_result,$clientType);
        return $userResult;


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