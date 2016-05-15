<?php
namespace wap\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\WebService;
use common\helpers\RequestHelper;
use common\helpers\RealNameHelper;
use common\helpers\UserInfoHelper;
use yii\helpers\Url;

/**
 * Site controller
 */
class WithdrawController extends \wap\controllers\BaseLoginController
{
    public $layout = false;
    public $phone =  'phone';
    //ajax提交主要要设置个属性否则post提交失败 todo

    /*
     * 体现首页
     */
    public function actionIndex()
    {
        $result = UserInfoHelper::getUserInfo(Yii::$app->user->id,\Yii::$app->params['clientType']);
        $balance = (isset($result['account_result']['balance'])  && !empty($result['account_result']['balance'])) ? $result['account_result']['balance'] : '0.00';
        return $this->render('withdraw',[
            'blance'=>$balance
        ]);
    }
    /*
     *提现
     */
    public function actionGoWithdraw(){
        //判断是否实名认证如果这样不友好提前走ajax跳转
        if(!RealNameHelper::getUserRealNameStatus(Yii::$app->user->id,Yii::$app->params['clientType'])){
            Yii::$app->getSession()->setFlash('error', '还没有实名认证');
            //return $this->redirect(['/realname']);
            return $this->redirect(Url::toRoute('/realname'));
        }
        //有没有绑卡
        $isbank_post['module']  = 'account';
        $isbank_post['q']  = 'get_users_bank_one';
        $isbank_post['user_id']      = intval(Yii::$app->user->id);
        $isbank_post['method']	= 'get';
        $isBank = WebService::clientSoap($isbank_post,Yii::$app->params['clientType']);
        if(!isset($isBank['username']) && empty($isBank['username'])){
           // return $this->redirect(['/bank']);
            return $this->redirect(Url::toRoute('/bank'));
        }
        //提现金额
        $money = RequestHelper::post('cashmoney');
        if(empty($money)){
            $this->nav_title = '提现';
            $this->message = '提现失败，提现金额为空';
            return $this->render('withdraw_err');
        }
        $money = number_format($money, 2, '.', '');

        //支付密码
        $user_result = array (
            "module" => "dyp2p",
            "q" => "get_users",
            "user_id" =>Yii::$app->user->id,
            "method" => "get"
        );
        //$userResult =   WebService::clientSoap($user_result,Yii::$app->params['clientType']);
        //有没有设置支付密码
        $userResult =   WebService::clientSoap($user_result,Yii::$app->params['clientType']);
        if(!isset($userResult['user_result']['paypassword']) || empty($userResult['user_result']['paypassword'])) {
            //return $this->redirect(['/users/paypassword']);
            return $this->redirect(Url::toRoute('/users/paypassword'));
        }

        //支付密码
        $paypasswd = RequestHelper::post('paypassword');
        if(empty($paypasswd)){
            $this->nav_title = '提现';
            $this->message = '提现失败，提现支付密码为空';
            return $this->render('withdraw_err');
        }
        //提现

        $data_post['module']  = 'account';
        $data_post['q']  = 'cash_new';
        $data_post['method']       = 'post';
        $data_post['vip_status']  = 0;
        $data_post['user_id']      = intval(Yii::$app->user->id);
        $data_post['paypassword']      =  $paypasswd;
        $data_post['userinfo_paypassword']  = (isset($userResult['user_result']['paypassword'])) ?  $userResult['user_result']['paypassword'] : '';
        $data_post['money']        = $money;
        $data_post['vouchers']   = 2;//不抵用代金券
        $result = WebService::clientSoap($data_post,Yii::$app->params['clientType']);
        if($result['result']=='success'){
            $this->nav_title = '提现';
            $this->message = '提交成功';
            return $this->render('withdraw_ok',[
                'cashmoney'=>$money,
                'balance'=>$money,
                'bank'=>'',
                'cashtime'=>''
            ]);
        }else{
            $this->nav_title = '提现';
            $this->message =  $result['error_remark'];
            return $this->render('withdraw_err');
        }

    }



}
