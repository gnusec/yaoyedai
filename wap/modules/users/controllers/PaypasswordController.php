<?php

namespace wap\modules\users\controllers;
use Yii;
use yii\web\Controller;
use common\wechat\Wechat;
use common\helpers\WebService;
use common\helpers\RequestHelper;
use wap\models\ReturnModel;

class PaypasswordController extends \wap\controllers\BaseLoginController
{

    public $layout = false;
    public $enableCsrfValidation = false;
    /*
     * 设置交易密码首页
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    /*
     *设置交易密码
     */

    public function actionUpd(){
        $returnModel = new ReturnModel();
        $oldpasswd = RequestHelper::get('oldpasswd');
        $newpasswd = RequestHelper::get('newpasswd');
        $repeatpasswd = RequestHelper::get('repeatpasswd');

        if(empty($oldpasswd)||empty($newpasswd)){
            $returnModel->initFail('参数为空','fail');
            echo json_encode($returnModel);exit;
        }


        //支付密码
        $user_result = array (
            "module" => "dyp2p",
            "q" => "get_users",
            "user_id" =>Yii::$app->user->id,
            "method" => "get"
        );
        $userResult =   WebService::clientSoap($user_result,Yii::$app->params['clientType']);

        if(!isset($userResult['user_result']['paypassword']) || $userResult['user_result']['paypassword']==""){
            if(md5($oldpasswd)!=$userResult['user_result']['password']){
                $returnModel->initFail('原支付密码输入不正确','fail');
                echo json_encode($returnModel);exit;
            }
        }

        if(isset($userResult['user_result']['paypassword']) && $userResult['user_result']['paypassword']!=""){
            if(md5($oldpasswd)!=$userResult['user_result']['paypassword']){
                $returnModel->initFail('原支付密码输入不正确','fail');
                echo json_encode($returnModel);exit;
            }
        }


        if($oldpasswd==$newpasswd){
            $returnModel->initFail('新密码不能和旧密码相同','fail');
            echo json_encode($returnModel);exit;
        }

        if($repeatpasswd!=$newpasswd){
            $returnModel->initFail('密码不一致','fail');
            echo json_encode($returnModel);exit;
        }

        $data['user_id'] = Yii::$app->user->id;
        $data['oldpassword'] = $oldpasswd;
        $data['paypassword'] = $newpasswd;
        $data['module']	= 'users';
        $data['q']			= 'update_paypassword';
        $_result =   WebService::clientSoap($data,Yii::$app->params['clientType']);
        if ($_result['result']!='success'){
            $returnModel->initFail($_result['error_remark'],'fail');
            echo json_encode($returnModel);exit;
        }

        echo json_encode($returnModel);exit;

    }


}
