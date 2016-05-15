<?php
namespace wap\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\helpers\UserInfoHelper;
use common\models\LoginForm;
use common\helpers\WebService;
use common\helpers\RequestHelper;
use \yii\base\Exception;
use \common\log\LogUtil;
use yii\helpers\Url;


class DealController extends \wap\controllers\BaseLoginController
{

    public $layout = false;

    /*
     *标的详情页
     */
    public function actionDealView(){
        //展示页面类型
        $dealId   =  RequestHelper::get('dealid');
        try{
            if($dealId<1){
                throw new Exception('错误的标的信息');
            }
            $deal = array(
                'module'=>'borrow'
                ,'q'=>'get_list'
                ,'method'=>'get'
                ,'borrow_nid'=>$dealId
            );
            $dealinfo = WebService::clientSoap($deal,Yii::$app->params['clientType']);
            $dealinfo = empty($dealinfo['list'][0]) ? '' : $dealinfo['list'][0];
           //var_dump($dealinfo);exit;
        }catch(\Exception  $ex){
            LogUtil::log($ex->getMessage(),'dealerr');
        }
        return $this->render('dealdetail',[
            'dealinfo'=>$dealinfo,
        ]);

    }
    /*
     * 投标确认页面
     */
    public function actionConfim(){
        $borrow_nid   =  RequestHelper::get('dealid');
        try{
            if($borrow_nid<1){
                throw new Exception('错误的标的信息');
            }
            $deal = array(
                'module'=>'borrow'
                ,'q'=>'get_view_one'
                ,'method'=>'get'
                ,'borrow_nid'=>$borrow_nid
                ,'hits'=>'auto'
            );
            $dealinfo = WebService::clientSoap($deal,Yii::$app->params['clientType']);

            if(empty($dealinfo)){
                throw new Exception('错误的标的信息');
            }
            //流转标
            $roamInfo = null;
            //代金券标
            $couponInfo = null;
            //普通标
            $template = 'dealconfim';
            if($dealinfo['borrow_type'] == 'roam'){
                //加载流转标模板
                $template = 'roamdealconfim';
                //流转标附加信息
                $roamInfo =   WebService::clientSoap(array('module'=>'borrow','q'=>'get_roam_one','borrow_nid'=>$borrow_nid,'method'=>'get'),Yii::$app->params['clientType']);
                if(empty($roamInfo)){
                    throw new Exception('流转标的信息异常未取出！');
                }

            }else if($dealinfo['borrow_type'] == 'welfare'){
                //代金券标
                $couponInfo =   WebService::clientSoap(array('module'=>'vouchers','q'=>'vouchers_use_list','user_id'=>Yii::$app->user->id,'method'=>'get'),Yii::$app->params['clientType']);
                $couponInfo = isset($couponInfo['list']) ? $couponInfo['list'] : '';

            }

            //有没有设置支付密码
            $user_result = array (
                "module" => "dyp2p",
                "q" => "get_users",
                "user_id" =>Yii::$app->user->id,
                "method" => "get"
            );
            $userResult =   WebService::clientSoap($user_result,Yii::$app->params['clientType']);
            if(!isset($userResult['user_result']['paypassword']) || empty($userResult['user_result']['paypassword'])) {
                //return $this->redirect(['/users/paypassword']);
                return $this->redirect(Url::toRoute('/users/paypassword'));
            }

            //手机认证

            $user_result = array (
                "module" => "dyp2p",
                "q" => "get_users",
                "user_id" =>Yii::$app->user->id,
                "method" => "get"
            );
            $userResult =   WebService::clientSoap($user_result,\Yii::$app->params['clientType']);

            if(!isset($userResult['approve_result']['phone_status']) || $userResult['approve_result']['phone_status']!=1){
                throw new Exception('还没有手机认证，请先认证手机！');
            }

            $result = UserInfoHelper::getUserInfo(Yii::$app->user->id,\Yii::$app->params['clientType']);
            $balance = (isset($result['account_result']['balance'])  && !empty($result['account_result']['balance'])) ? $result['account_result']['balance'] : '0.00';

        }catch(\Exception  $ex){
            //获取标的详细信息异常记录日志展示错误页面
            LogUtil::log($ex->getMessage(),'dealerr');
            $this->nav_title = '投标';
            $this->message = $ex->getMessage();
            return $this->render('deal_message');
        }
        //一切正常走下来
        $key = md5("borrow/tender/new");
        $_SESSION[$key]  = md5(time());
        return $this->render($template,[
            'confimdealinfo'=>$dealinfo,
            'roaminfo'=>$roamInfo,
            'balance'=>$balance,
            'couponInfo'=>$couponInfo
        ]);
    }

    /*
     * 投标目前不支持密码标
     */

    public function actionDeal(){
        //表单提交防止短时间内重复提交
        $key = md5("borrow/tender/new");

        $borrowid = RequestHelper::post('borrow_nid');
        $account = RequestHelper::post('account');
        $paypassword = RequestHelper::post('paypassword');
        $borrow_password = RequestHelper::post('borrow_password');
        $vouchers = RequestHelper::post('vouchers');
        $serial = RequestHelper::post('serial');

        if(empty($account) || empty($borrowid) || empty($paypassword)){
            $this->nav_title = '投标';
            $this->message = '投资失败，参数不合法';
            return $this->render('deal_message');
        }
        $account = number_format($account, 2, '.', '');
        //支付密码
        $user_result = array (
            "module" => "dyp2p",
            "q" => "get_users",
            "user_id" =>Yii::$app->user->id,
            "method" => "get"
        );
        $userResult =   WebService::clientSoap($user_result,Yii::$app->params['clientType']);
        if(!isset($userResult['user_result']['paypassword']) || empty($userResult['user_result']['paypassword'])){
           // return $this->redirect(['/users/paypassword']);
            return $this->redirect(Url::toRoute('/users/paypassword'));
        }

        //安装不同标的类型区分投标方法目前不支持密码标 todo

        if(isset($_SESSION[$key])){
            unset($_SESSION[$key]);
            $data['module']  = 'borrow';
            $data['q']       = 'tender';
            $data['user_id']    = Yii::$app->user->id;
            $data['borrow_nid'] =$borrowid;
            $data['account']	 = $account;
            $data['paypassword']	 = $paypassword;
            $data['borrow_password']	 = $borrow_password;
            $data['vouchers']     = $vouchers;
            $data['serial']     = $serial;

            $result = WebService::clientSoap($data,Yii::$app->params['clientType']);
            if($result['result'] == "success"){
                $this->nav_title = '投标';
                $this->message = '投标成功';
                return $this->render('deal_message');
            }else{
                $this->nav_title = '投标';
                $this->message = empty($result['error_remark'])?$result['error_msg']:$result['error_remark'];
                return $this->render('deal_message');
            }
        }else{
            $this->nav_title = '投标';
            $this->message = '您已经提交了,请不要多次提交';
            return $this->render('deal_message');
        }


    }

    /*
     * 投资流转标fun
     */
    public function actionRoamDeal(){
        //防止客户端重复刷新标的
        $key = md5("borrow/tender/new");
        $account_min = RequestHelper::post('account_min');
        $roam_account = RequestHelper::post('roam_account');
        $borrow_nid = RequestHelper::post('borrow_nid');
        $paypassword = RequestHelper::post('paypassword');

        if(empty($account_min) || empty($roam_account) || empty($borrow_nid) || empty($paypassword)){
            $this->nav_title = '投标';
            $this->message = '投资失败,参数错误！';
            return $this->render('deal_message');
        }
        //开始投资
        try{
            if(isset($_SESSION[$key])){
                unset($_SESSION[$key]);
                $data['account'] = $account_min*intval($roam_account);
                $data['user_id'] = Yii::$app->user->id;
                $data['borrow_nid']=$borrow_nid;
                $data['paypassword']	 = $paypassword;
                $data['module']  = 'borrow';
                $data['q']       = 'tender';
                $result = WebService::clientSoap($data,Yii::$app->params['clientType']);

                if($result['result'] == "success"){
                    $this->nav_title = '投标';
                    $this->message = '投标成功';
                    return $this->render('deal_message');
                }else{
                    $this->nav_title = '投标';
                    $this->message = empty($result['error_remark'])?$result['error_msg']:$result['error_remark'];
                    return $this->render('deal_message');
                }
            }else{
                $this->nav_title = '投标';
                $this->message = '您已经提交了,请不要多次提交';
                return $this->render('deal_message');
            }
        }catch(\Exception  $ex){
            LogUtil::log($ex->getMessage(),'recharge_err');
            $this->nav_title = '投资';
            $this->message = '投资出现异常';
            return $this->render('deal_message');
        }

    }

    /*
     * 基本信息
     */

    public function actionBasicInfo(){
        $dealId   =  RequestHelper::get('dealid');
        try {
            if ($dealId < 1) {
                throw new Exception('错误的标的信息');
            }
            $deal = array(
                'module' => 'borrow'
                , 'q' => 'get_list'
                , 'method' => 'get'
                , 'borrow_nid' => $dealId
            );
            $dealinfo = WebService::clientSoap($deal, Yii::$app->params['clientType']);
            $dealinfo = empty($dealinfo['list'][0]) ? '' : $dealinfo['list'][0];

            if(empty($dealinfo)){
                throw new Exception('错误的标的信息');
            }

            return $this->render('dealbasic',[
                'basicinfo'=>$dealinfo['borrow_contents'],
            ]);
        }catch(\Exception  $ex){
                LogUtil::log($ex->getMessage(),'dealerr');
        }

    }

    /*
     * 借款介绍
     */

    public function actionDealIntroduction(){

    }


    /*
     * 交易记录
     */

    public function actionTradeRecord(){
        $dealId   =  RequestHelper::get('dealid');
        $deal = array(
            'module' => 'borrow'
            , 'q' => 'get_tender_list'
            , 'method' => 'get'
            , 'borrow_nid' => $dealId
            , 'limit' => 'all'
            , 'order' => 'tender_addtime'
            , 'datacache' => 'none'
            , 'datacachename' => 'broww_article_get_tender_list'
            , 'datacachenametimes' => '60*30'
            , 'bindkey' => $dealId
        );
        $dealinfo = WebService::clientSoap($deal, Yii::$app->params['clientType']);
        $traderecord = (isset($dealinfo['list']) && !empty($dealinfo['list'])) ? $dealinfo['list'] : '';
        //var_dump($traderecord);exit;
        return $this->render('traderecord',[
            'list'=>$traderecord,
        ]);


    }


    /*
     * 流转历史记录
     */

    public function actionFlowRecord(){

        $deal = array(
            'module' => 'borrow'
            , 'q' => 'get_user_roam_count'
            , 'method' => 'get'
            , 'user_id' => Yii::$app->user->id
        );
        $floowHistory = WebService::clientSoap($deal, Yii::$app->params['clientType']);
        var_dump($floowHistory);exit;

//        {articles module="borrow" function="get_user_roam_count" user_id=$var.user_id var="cvar"}
//        <tbody>
//			     <tr>
//					 <td>成功流转：</td>
//					 <td>￥{$cvar.month.success_account|default:'0.00'}</td>
//					 <td>￥{$cvar.half.success_account|default:'0.00'}</td>
//					 <td>￥{$cvar.year.success_account|default:'0.00'}</td>
//					 <td>￥{$cvar.all.success_account|default:'0.00'}</td>
//				 <tr>
//				 <tr>
//					 <td>成功回购：</td>
//					 <td>￥{$cvar.month.recover_account|default:'0.00'}</td>
//					 <td>￥{$cvar.half.recover_account|default:'0.00'}</td>
//					 <td>￥{$cvar.year.recover_account|default:'0.00'}</td>
//					 <td>￥{$cvar.all.recover_account|default:'0.00'}</td>
//				 <tr>
//				 <tr>
//					 <td>逾期违约：</td>
//					 <td>￥{$cvar.month.late_account|default:'0.00'}</td>
//					 <td>￥{$cvar.half.late_account|default:'0.00'}</td>
//					 <td>￥{$cvar.year.late_account|default:'0.00'}</td>
//					 <td>￥{$cvar.all.late_account|default:'0.00'}</td>
//				 <tr>
//				 <tr>
//					 <td>累计利息成本：</td>
//					 <td>￥{$cvar.month.success_interest|default:'0.00'}</td>
//					 <td>￥{$cvar.half.success_interest|default:'0.00'}</td>
//					 <td>￥{$cvar.year.success_interest|default:'0.00'}</td>
//					 <td>￥{$cvar.all.success_interest|default:'0.00'}</td>
//				 <tr>
//				 <tr>
//					 <td>逾期还款率：</td>
//					 <td>{$cvar.month.late_apr}%</td>
//					 <td>{$cvar.half.late_apr}%</td>
//					 <td>{$cvar.year.late_apr}%</td>
//					 <td>{$cvar.all.late_apr}%</td>
//				 <tr>
//			  </tbody>
//			  {/articles}





    }



}
