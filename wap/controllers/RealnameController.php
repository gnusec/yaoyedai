<?php
namespace wap\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\WebService;
use common\helpers\RequestHelper;
use common\helpers\RealNameHelper;
use common\helpers\UserInfoHelper;
use wap\models\ReturnModel;
use \yii\base\Exception;
use \common\log\LogUtil;

class RealnameController extends \wap\controllers\BaseLoginController
{
    public $layout = false;
    public $enableCsrfValidation = false;
    //实名认证费用默认2元
    private $realnamefee = 2;

    /*
     * 实名认证首页
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /*
     * 开通实名认证
     */

    public function actionGoRealName(){
        $returnModel = new ReturnModel();
        $username = RequestHelper::post('username');
        $cardId = RequestHelper::post('cardid');
        //是否登录
        $this->isLogin();
        if(empty($username)){
            $returnModel->initFail('用户名为空','fail');
            echo json_encode($returnModel);exit;
        }
        if(empty($cardId)){
            $returnModel->initFail('身份证号为空','fail');
            echo json_encode($returnModel);exit;
        }

        //验证身份证
        if(RealNameHelper::getUserRealNameStatus(Yii::$app->user->id,Yii::$app->params['clientType'])){
            $returnModel->initFail('已经实名认证过','fail');
            echo json_encode($returnModel);exit;
        }

        //身份证是否验证
        if(RealNameHelper::getCardId($cardId,Yii::$app->params['clientType'])){
            $returnModel->initFail('身份证已经被认证过','fail');
            echo json_encode($returnModel);exit;
        }
        //进行实名认证
        try{
            //获取系统配置
            $system =  WebService::clientSoap(array('module' => 'system','q' => 'get_list','limit' => 'all','method' => 'post'),Yii::$app->params['clientType']);
            if ($system ['result'] != 'success') {
                throw new Exception('开通实名认证失败！获取系统配置信息异常。'.$system ['error_remark']);
            }
            foreach ($system['list'] as $key => $value){
                $system[$value['nid']] = $value['value'];
            }
            $fee=isset($system['con_realname_fee'])?$system['con_realname_fee']:$this->realnamefee;
            //查看用户账户余额
            $result = UserInfoHelper::getUserInfo(Yii::$app->user->id,\Yii::$app->params['clientType']);
            $balance = (isset($result['account_result']['balance'])  && !empty($result['account_result']['balance'])) ? $result['account_result']['balance'] : '0';
            if ($balance<$fee && $fee!=0){
                $returnModel->initFail('余额不足'.$this->realnamefee.'元，请先充值','fail');
                echo json_encode($returnModel);exit;
            }

            $open['module']	= 'approve';
            $open['q']		= 'add_realname';
            $open ['user_id'] = Yii::$app->user->id;
            $open ['realname'] = $username;
            $open ['sex'] = '';
            $open ['card_id'] = $cardId;
            $open ['status'] = 0;
            $open['method']	= 'post';
            $openresult =  WebService::clientSoap($open,Yii::$app->params['clientType']);
            if($openresult['result']!='success'){
                $returnModel->initFail($openresult['error_remark'],'fail');
                echo json_encode($returnModel);exit;
            }

            if($fee!=0){
                //扣除认证费用
                $log_info["user_id"] = Yii::$app->user->id;//操作用户id
                $log_info["nid"] = "realname_approve_".Yii::$app->user->id;//订单号
                $log_info["account_web_status"] = 1;//
                $log_info["account_user_status"] = 1;//
                $log_info["code"] = "user";//
                $log_info["code_type"] = "realname_approve";//
                $log_info["code_nid"] = Yii::$app->user->id;//
                $log_info["money"] = $fee;//操作金额
                $log_info["income"] = 0;//收入
                $log_info["expend"] =$log_info["money"];//支出
                $log_info["balance_cash"] = -$fee;//可提现金额
                $log_info["balance_frost"] =0;//不可提现金额
                $log_info["frost"] = 0;//冻结金额
                $log_info["await"] = 0;//待收金额
                $log_info["type"] = "realname_approve";//类型
                $log_info["to_userid"] = Yii::$app->user->id;//付给谁
                $log_info["remark"] = "姓名认证添加成功，扣除{$log_info["money"]}元";
                $log_info ['module'] = 'account';
                $log_info ['q'] = 'add_log';
                $log_info ['method'] = 'post';
                $logresult =  WebService::clientSoap($log_info,Yii::$app->params['clientType']);
            }
        }catch(\Exception  $ex){
            LogUtil::log($ex->getMessage(),'realname_err');
            $returnModel->initFail('实名认证异常','fail');
            echo json_encode($returnModel);exit;
        }
        //认证成功
        echo json_encode($returnModel);exit;

    }

    /*
     * 实名认证成功页面
     */

    public function actionRealOk(){

        return $this->render('realnameok');
    }


}
