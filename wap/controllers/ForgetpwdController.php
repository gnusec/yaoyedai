<?php
namespace wap\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\WebService;
use wap\models\ReturnModel;
use common\log\LogUtil;
use common\helpers\RequestHelper;
use common\models\LoginForm;

class LoginController extends Controller
{
    public $layout = false;
    public $enableCsrfValidation = false;
    public function init()
    {
       session_start();
    }

    public function actionIndex()
    {

        return $this->render('index');
    }


    public function actionFindPwd(){
        $returnModel = new ReturnModel();
        //找回类型
        $findType = RequestHelper::post('findtype');
        //验证码
        $phoneCode = RequestHelper::post('phonecode');
        //手机号
        $phone = RequestHelper::post('phone');

        if(empty($findType)){
            $returnModel->initFail('参数错误','fail');
            echo json_encode($returnModel);exit;
        }

        if(empty($phone)){
            $returnModel->initFail('手机号不能为空','fail');
            echo json_encode($returnModel);exit;
        }

        if($findType != 'phone'){
            $returnModel->initFail('参数错误','fail');
            echo json_encode($returnModel);exit;
        }

        if(isset($_SESSION['valicode']) && $phoneCode!=$_SESSION['valicode']){
            $returnModel->initFail('验证码错误','fail');
            echo json_encode($returnModel);exit;
        }

        $_data['phone'] = $phone;
        $_data['status'] = 1;
        $_data['module'] = "phone";
        $_data['q'] = "get_phone_one";
        $_data['method'] = "get";
        $result_phone = WebService::clientSoap($_data,Yii::$app->params['clientType']);

        //成功转向下一页由js转
        if (empty($result_phone['user_id'])){
            die(json_encode(array('code'=>'03','msg'=>'手机不存在或者此手机还没认证')));
        }else{
            die(json_encode(array('code'=>'101','msg'=>'手机号合法')));
        }


    }

    public function actionSendCode(){
        if (empty($_POST['phone'])){
            die(json_encode(array('code'=>'02','msg'=>'手机号码不能为空')));
        }else{
            $_data['phone'] = $_POST['phone'];
            $_data['status'] = 1;
            $_data['module'] = "phone";
            $_data['q'] = "get_phone_one";
            $_data['method'] = "get";
            $result_phone=dy_get_server($_data);

            if (empty($result_phone['user_id'])){
                die(json_encode(array('code'=>'03','msg'=>'手机不存在或者此手机还没认证')));
            }else{
                if (isset($_SESSION['sendpwd_time']) && $_SESSION['sendpwd_time']+60*2>time()){
                    die(json_encode(array('code'=>'04','msg'=>'请2分钟后再次请求')));
                }else{
                    //发送短信
                    //2015-01-13 xzy  产生6位字母加数字随机字符串
                    $randomcode = random(6);
                    $_SESSION['phonevalid'] = $randomcode;
                    //2015-01-13 xzy 手机验证码错误次数
                    $_SESSION['phonevalid_error_count'] = 0;
                    //$_SESSION['phonevalid'] = rand(100000,999999);
                    $data['contents'] = '您取回登录密码验证码为：'.$_SESSION['phonevalid'];
                    $data['phone']   = $_POST['phone'];
                    $data['user_id'] = $result_phone['user_id'];
                    $data['nid']     = time();
                    $data['type']    = 'smscode';
                    $data['module']  = 'phone';
                    $data['q']       = 'send';
                    $result = dy_get_server($data);
                    if($result['result']=='success'){
                        $_SESSION['sendpwd_time']=time();
                        die(json_encode(array('code'=>'102','msg'=>'验证码发送成功')));
                    }else{
                        die(json_encode(array('code'=>'98','msg'=>'验证码发送失败，'.$result['error_remark'])));
                    }

                }
            }
        }
    }


    /*
     * 修改密码
     */

    public function actionUpdPwd(){
        if (empty($_POST['password'])){die(json_encode(array('code'=>'06','msg'=>'密码不能为空')));}
        if($_POST['password']!=$_POST['comfirm_password']){die(json_encode(array('code'=>'07','msg'=>'两次密码不一致')));}
        if(strlen($_POST['password'])<6||strlen($_POST['password'])>15){die(json_encode(array('code'=>'08','msg'=>'密码必须在6-15个字符之间')));}
        if(!preg_match("/^[0-9a-zA-Z]*$/",$_POST['password'])){die(json_encode(array('code'=>'09','msg'=>'密码格式错误，请输入英文，数字组合')));}    //yjt preg_match中添加定界符；
        if($_POST['dotype']=='phone'){
            if(empty($_SESSION['phonevalid'])||empty($_SESSION['phone'])){die(json_encode(array('code'=>'10','msg'=>'请输入手机号码与短信验证码')));}

            $_data ['phone'] = $_SESSION ['phone_checked'];//用已校验通过的手机号码
            $_data['module'] = "phone";
            $_data['q'] = "get_phone_one";
            $_data['method'] = "get";
            $result_phone=dy_get_server($_data);
            if (empty($result_phone['user_id'])){die(json_encode(array('code'=>'03','msg'=>'手机不存在或者此手机还没认证')));}
            $user_id=$result_phone['user_id'];
            unset($_SESSION['phonevalid']);unset($_SESSION['phone']);unset ( $_SESSION ['phone_checked'] );
        }
        if($_POST['dotype']=='email'){
            if(empty(Yii::$app->user->id)){die(json_encode(array('code'=>'13','msg'=>'请点击邮箱的激活链接修改密码')));}
            $_data['user_id'] = Yii::$app->user->id;
            $_data['module'] = "users";
            $_data['q'] = "get_user_one";
            $_data['method'] = "get";
            $user_result=dy_get_server($_data);
            if ($user_result['result'] != 'success'){die(json_encode(array('code'=>'12','msg'=>'您的操作有误')));}
            $user_id=$user_result['user_id'];
            unset(Yii::$app->user->id);
        }


        $user['user_id'] = $user_id;
        $user['password'] = $_POST['password'];
        $user['module'] = "users";
        $user['q'] = "update_userpwd";
        $result=dy_get_server($user);
        if ($result['result'] != 'success'){
            die(json_encode(array('code'=>'96','msg'=>'登陆密码修改失败')));
        }else{
            die(json_encode(array('code'=>'104','msg'=>'登陆密码修改成功')));
        }
        exit;
    }



}
