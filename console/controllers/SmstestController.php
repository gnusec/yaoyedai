<?php

namespace console\controllers;
use common\models\vouchers\VouchTypes;
use common\models\vouchers\VouchersLog;
use common\models\borrowtender\BorrowTender;
use common\models\queue\Queue;
use common\models\queue\QueueLog;
use common\models\spreads\FriendsInvite;
use common\log\LogUtil;
use \yii\base\Exception;

use common\helpers\RemindHelper;

class SmstestController extends \yii\web\Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;
    const ACT_NAME = '投资代金券';
    const QUEUE_TYPE = 10;//类型10=>投资 20=>提现
    const VOUCHER_SINGLE = 10;//单笔
    const VOUCHER_TOTAL = 20;//总额




    public function actionIndex(){

        $remin = RemindHelper::getSmsIndentity('DEFAULT');
           $res =  $remin->sendsms('15510337665');

        //var_dump();exit;


    }



}
