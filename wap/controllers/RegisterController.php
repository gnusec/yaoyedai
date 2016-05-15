<?php
namespace wap\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\WebService;
use common\helpers\RequestHelper;
use common\helpers\FunHelper;
use common\log\LogUtil;
use common\helpers\Sign;
use wap\models\ReturnModel;
use yii\helpers\Url;

/**
 * Site controller
 */
class RegisterController extends Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;

    public function init(){
        session_start();
    }
    public function actionIndex()
    {
        //判断是否已经登录，登录跳转到用户中心
        if(!Yii::$app->user->isGuest){
            //return $this->redirect('/users/user');
            return $this->redirect(Url::toRoute('/users/user'));
        }
        //接收邀请人id
        $inviteId = RequestHelper::get('inviteid');
        $inviteId =  empty($inviteId) ?  '' :RequestHelper::get('inviteid');
        return $this->render('register',[
            'inviteid'=>$inviteId,
        ]);
    }

    /*
     * 注册下一步发送短信验证码
     */
    public function actionRegisterNext(){
        //接受参数发送短信验证码
        $phone = RequestHelper::get('phone');
        $password = RequestHelper::get('passwd');
        $inviteCode = RequestHelper::get('invitecode') ? RequestHelper::get('invitecode') : '';
        $sign = Sign::StrCrypt($phone.$password.$inviteCode);
        $_SESSION['regsn'] = $sign;
        return $this->render('register_next',[
            'phone'=>$phone,
            'password'=>$password,
            'invitecode'=>$inviteCode,
        ]);
    }
    /*
     * 注册
     */
    public function actionDoRegister(){
        $returnModel = new ReturnModel();
        //验证手机验证码
        $phoneCode = RequestHelper::get('phonecode');
        $phone = RequestHelper::get('phone');
        $password = RequestHelper::get('passwd');
        $inviteCode = RequestHelper::get('invitecode') ? RequestHelper::get('invitecode') : '';

        if(empty($phoneCode)){
            $returnModel->initFail('短信验证码为空','fail');
            echo json_encode($returnModel);exit;
        }
        //验证验证码是否正确防止接口非法调用必须判断session是否存在
        if(!isset($_SESSION['validate_phone_code']) || $_SESSION['validate_phone_code']!=$phoneCode){
            $returnModel->initFail('短信验证码不正确','fail');
            echo json_encode($returnModel);exit;
        }

        //验证短信验证码是否过期

        $checked['module']  = 'phone';
        $checked['q']       = 'check_code';
        $checked['phone'] = $phone;
        $checked['type'] = "reg";
        //$checked['reg_type'] = 'phone';
        $checked['method'] = "post";
        $checked['code'] = $phoneCode;
        $checked['user_id'] = '0';
        $r = WebService::clientSoap($checked,Yii::$app->params['clientType']);
        if ($r['result']!=='success'){
            $returnModel->initFail($r['error_remark'],'fail');
            echo json_encode($returnModel);exit;
        }
        //必须验证session是否存在
        if(!isset($_SESSION['regsn'])){
            $returnModel->initFail('参数不合法','fail');
            echo json_encode($returnModel);exit;
        }
        //解密验证
        $deSign = Sign::StrCrypt($_SESSION['regsn'],'DECODE');
        if($deSign != $phone.$password.$inviteCode){
            $returnModel->initFail('参数不合法','fail');
            echo json_encode($returnModel);exit;
        }

        //验证手机号是否能注册
        $api['module'] = 'users';
        $api['q']		= 'get_user_one_by_name';
        $api['method']		= 'get';
        $api['username']	= $phone;
        $api['user_id']    = 0;
        $result_username = WebService::clientSoap($api,Yii::$app->params['clientType']);
        $result_phone = WebService::clientSoap(array('module'=>'phone','q'=>'check_new_phone','method'=>'post','phone'=>$_REQUEST['phone']),Yii::$app->params['clientType']);
        if ($result_username['result']=='success' && $result_phone['result']=='success'){
            $returnModel->initFail('手机号不可以注册','fail');
            echo json_encode($returnModel);exit;
        }
        //验证通过进行注册
        //$var = array("phone","phone_code","invite_userid","password","user_role","invite_username");
        //$DataApi = FunHelper::post_var($var);
        $DataApi['module'] = 'users';
        $DataApi['q']      = 'reg';
        $DataApi['user_role'] = 1;
        $DataApi['reg_type'] = 6;
        //$DataApi['type']   = Yii::$app->params['clientType'];
        $DataApi['valid_time'] = 60;
        $DataApi['username'] = $phone;
        $DataApi['phone'] = $phone;
        $DataApi['phone_code'] = $phoneCode;
        $DataApi['invite_userid'] = $inviteCode;
        $DataApi['password'] = $password;
        $DataApi['method']= 'post';
        $result = WebService::clientSoap($DataApi,Yii::$app->params['clientType']);
        if ($result['result']!='success'){
            LogUtil::log('注册失败用户名'.$phone,'usersregister.log');
            $returnModel->initFail('注册失败','fail');
            echo json_encode($returnModel);exit;
        }
        //注册成功
        echo json_encode($returnModel);exit;

    }

    /*
     * 检测手机号是否能注册
     */
    public function actionCheckPhone(){
        $data['module'] = 'users';
        $data['q']		= 'get_user_one_by_name';
        $data['method']		= 'get';
        $data['username']	= $_REQUEST['phone'];
        $data['user_id']    = 0;
        $result_username = WebService::clientSoap($data,Yii::$app->params['clientType']);
        $result_phone = WebService::clientSoap(array('module'=>'phone','q'=>'check_new_phone','method'=>'post','phone'=>$_REQUEST['phone']),'wap');
        if ($result_username['result']!='success' && $result_phone['result']!='success'){
            die(json_encode(array('code'=>'100','msg'=>'可以注册')));
        }else{
            die(json_encode(array('code'=>'99','msg'=>'手机号已存在')));
        }
    }

    /*
     * 发送手机短信验证码
     */

    public function actionSendPhoneCode(){
        $returnModel = new ReturnModel();
        $phone = RequestHelper::get('phone');
        //验证手机号是否为空
        if(empty($phone)){
            $returnModel->initFail('手机号码为空','fail');
            echo json_encode($returnModel);exit;
        }
        if (isset($_SESSION['smscode_time']) && $_SESSION['smscode_time']+60>time()){
            $returnModel->initFail('请于60秒后再发送','fail');
            echo json_encode($returnModel);exit;
        }
        //请求接口
        $api['module']  = 'phone';
        $api['q']       = 'send_code';
        $api['user_id'] = 0;
        $api['type']    = 'reg';
        $api['reg_type']    = 'phone';
        $api['phone']   = RequestHelper::get('phone');
        $api['code']    = rand(100000,999999);
        $api['contents']= "您的手机验证码为:". $api['code'];
        $r = WebService::clientSoap($api,Yii::$app->params['clientType']);
        $_SESSION['validate_phone_code'] = $api['code'];
        if($r['result']!="success"){
            $returnModel->initFail($r['error_remark'],'fail');
            echo json_encode($returnModel);exit;
        }
        $_SESSION['smscode_time'] = time();
        echo json_encode($returnModel);exit;
    }


}
