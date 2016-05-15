<?php
namespace wap\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\WebService;
use wap\models\ReturnModel;
use common\log\LogUtil;
use common\helpers\RequestHelper;
use common\helpers\RealNameHelper;
use \yii\base\Exception;
use common\helpers\UserInfoHelper;
use yii\helpers\Url;

class RechargeController extends \wap\controllers\BaseLoginController
{
    public $layout = false;
    public $enableCsrfValidation = false;
    private $phone = 'phone';
    //ajax提交主要要设置个属性否则post提交失败 todo

    public function actionIndex()
    {
        //查询可投金额 todo
        $result = UserInfoHelper::getUserInfo(Yii::$app->user->id,\Yii::$app->params['clientType']);
        $balance = (isset($result['account_result']['balance'])  && !empty($result['account_result']['balance'])) ? $result['account_result']['balance'] : '0.00';
        return $this->render('recharge',[
            'blance'=>$balance,
        ]);
    }

    /*
     * 查看限额
     */

    public function actionViewLimitMoney(){

        return $this->render('recharge_limit_quota');
    }

    //充值
    public function actionGoRecharge(){
        //验证前端+后台 前端尽量改为 submit todo
        $money = RequestHelper::post('chargemoney');
        if(empty($money)){
            $this->nav_title = '充值';
            $this->message = '充值金额不合法';
            return $this->render('recharge_message');
        }
        $money = number_format($money, 2, '.', '');

        //判断是否实名认证如果这样不友好提前走ajax跳转
        if(!RealNameHelper::getUserRealNameStatus(Yii::$app->user->id,Yii::$app->params['clientType'])){
            Yii::$app->getSession()->setFlash('error', '还没有实名认证');
            //return $this->redirect(['/realname']);
            return $this->redirect(Url::toRoute('/realname'));
        }
        try{
            //计算手续费
            $chargeFee = array(
                'module'=>'account'
                ,'q'=>'get_fee_value'
                ,'user_id'=>Yii::$app->user->id
                ,'type'=>'recharge_success'
                ,'account'=>$money
                ,'vip_status'=>''
                ,'payment_nid'=>'yeepay'
            );
            $result = WebService::clientSoap($chargeFee,$this->phone);
            //组合手续费准备下次充值请求
            $api['fee'] = $result['account_fee'];
            $api['remark'] = "在线充值";
            //格式化 tudo
            $api ['balance'] = $money - $api['fee'];
            //充值
            $api['module'] = 'account';
            $api['q']		= 'add_yeepay_payment';
            $api['method']		= 'get';
            $api['webname']	= Yii::$app->params['clientType'];
            $api['subject']    = 0;
            $api['trade_no']    = time() . rand(1000, 9999) . Yii::$app->user->id;
            //$api['url']    = '';
            //$api['return']    = '';
            //$api['type']    = '';
            //$api['sign']    = '';
            $api['payment']    = 'yeepay';
            $api['money']    = $money;
            $api['bankCode']    = '';
            $api['client_type']    = 'wap';
            $api['user_id']    = Yii::$app->user->id;
            $result_username = WebService::clientSoap($api,$this->phone);
            echo "<script>location.href='".urldecode($result_username['url'])."'</script>";
        }catch(\Exception  $ex){
            LogUtil::log($ex->getMessage(),'recharge_err');
            $this->nav_title = '充值';
            $this->message = '充值异常';
            return $this->render('recharge_message');
        }
    }

}
