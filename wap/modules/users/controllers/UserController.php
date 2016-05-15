<?php

namespace wap\modules\users\controllers;
use Yii;
use yii\web\Controller;
use common\helpers\RealNameHelper;
use common\helpers\UserInfoHelper;
use common\helpers\WebService;

class UserController extends \wap\controllers\BaseLoginController
{
    public $enableCsrfValidation = false;
    public $layout = false;
    public function actionIndex()
    {
        //可用余额
        $result = UserInfoHelper::getUserInfo( Yii::$app->user->id,\Yii::$app->params['clientType']);

        $balance = (isset($result['account_result']['balance'])  && !empty($result['account_result']['balance'])) ? $result['account_result']['balance'] : '0.00';

        //冻结金额
        $frost = (isset($result['account_result']['_frost'])  && !empty($result['account_result']['_frost'])) ? $result['account_result']['_frost'] : '0.00';

        //账户总额
        $total = (isset($result['account_result']['_total'])  && !empty($result['account_result']['_total'])) ? $result['account_result']['_total'] : '0.00';

        //当前待收本金
        $tender_wait_capital = (isset($result['account_result']['tender_wait_capital'])  && !empty($result['account_result']['tender_wait_capital'])) ? $result['account_result']['tender_wait_capital'] : '0.00';

        //已收利息
        $result = WebService::clientSoap(array('module'=>'borrow',
            'q'=>'get_count_user_recover_count',
            'method'=>'get',
            'user_id'=> Yii::$app->user->id,
            ),Yii::$app->params['clientType']);
        $recover_yes_interest = (isset($result['recover_yes_interest']) && !empty($result['recover_yes_interest'])) ? $result['recover_yes_interest'] : '0.00';
        //待收利息
        $tender_wait_interest = (isset($result['account_result']['tender_wait_interest'])  && !empty($result['account_result']['tender_wait_interest'])) ? $result['account_result']['tender_wait_interest'] : '0.00';

        return $this->render('index',[
            'balance'=>$balance,
            'frost'=>$frost,
            'total'=>$total,
            'tender_wait_capital'=>$tender_wait_capital,
            'recover_yes_interest'=>$recover_yes_interest,
            'tender_wait_interest'=>$tender_wait_interest,

        ]);
    }
    //查询个人信息
    public function actionUserinfo(){
        $userInfo = RealNameHelper::getUsrRealNameInfo( Yii::$app->user->id,\Yii::$app->params['clientType']);
        $realName = (isset($userInfo['realname_result']['realname']) && !empty($userInfo['realname_result']['realname'])) ? $userInfo['realname_result']['realname'] : '';
        $card_id = (isset($userInfo['realname_result']['_card_id']) && ! empty($userInfo['realname_result']['_card_id'])) ? $userInfo['realname_result']['_card_id'] : '';
        $username = (isset($userInfo['realname_result']['username']) && !empty($userInfo['realname_result']['username'])) ? $userInfo['realname_result']['username'] : '';

        return $this->render('userinfo',[
            'realName'=>$realName,
            'card_id'=>$card_id,
            'username'=>$username,
        ]);
    }

    /*
     * 银行卡管理
     */

    public function actionCardManage(){


    }

}
