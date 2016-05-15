<?php
namespace wap\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\WebService;
use common\helpers\RequestHelper;
use common\helpers\AreasHelper;
use wap\models\ReturnModel;
use common\helpers\RealNameHelper;
use \yii\base\Exception;
use \common\log\LogUtil;
use yii\helpers\Url;

class BankController extends \wap\controllers\BaseLoginController
{
    public $layout = false;
    public $enableCsrfValidation = false;

    /*
     * 绑卡首页
     */
    public function actionIndex()
    {
        //先去验证实名认证
        if(!RealNameHelper::getUserRealNameStatus(Yii::$app->user->id,Yii::$app->params['clientType'])){
            Yii::$app->getSession()->setFlash('error', '还没有实名认证');
            //return $this->redirect(['/realname']);
            return $this->redirect(Url::toRoute('/realname'));
        }
        //获取真实姓名
        $userInfo = RealNameHelper::getUsrRealNameInfo(Yii::$app->user->id,\Yii::$app->params['clientType']);
        $realName = (isset($userInfo['realname_result']['realname']) && !empty($userInfo['realname_result']['realname'])) ? $userInfo['realname_result']['realname'] : '';
        $open['module']	= 'linkages';
        $open['q']		= 'get_list';
        $open ['limit'] = 'all';
        $open['method']	= 'get';
        $openresult =  WebService::clientSoap($open,Yii::$app->params['clientType']);

        foreach ($openresult['list'] as $key => $value) {
            $_G['linkages'][$value['type_nid']][$value['value']] = $value['name'];
            $_G['linkages'][$value['id']] = $value['name'];
            if ($value['type_nid'] != '') {
                $_G['_linkages'][$value['type_nid']][$value['id']] = array("name"=>$value['name'],"id"=>$value['id'],"value"=>$value['value']);
            }
        }

        return $this->render('index',[
            'banklist'=>$_G['_linkages']['account_bank'],
            'realName'=>$realName,
        ]);
    }

    /*
     * 绑卡
     */

    public function actionGoBank(){
        //判断是否实名认证如果这样不友好提前走ajax跳转
        if(!RealNameHelper::getUserRealNameStatus(Yii::$app->user->id,Yii::$app->params['clientType'])){
            Yii::$app->getSession()->setFlash('error', '还没有实名认证');
            //return $this->redirect(['/realname']);
            return $this->redirect(Url::toRoute('/realname'));
        }
        $account = RequestHelper::post('account');
        $bank = RequestHelper::post('bank');
        $province = RequestHelper::post('province');
        $city = RequestHelper::post('city');
        $branch = RequestHelper::post('branch');
        $confirm_account = RequestHelper::post('confirm_account');

        if(empty($account)){
            $this->nav_title = '绑卡';
            $this->message = '绑卡失败，请填写银行卡';
            return $this->render('bank_message');
        }

        if(empty($bank)){
            $this->nav_title = '绑卡';
            $this->message = '绑卡失败，请选择银行';
            return $this->render('bank_message');
        }

        if(empty($province)){
            $this->nav_title = '绑卡';
            $this->message = '绑卡失败，请选择省份';
            return $this->render('bank_message');
        }

        if(empty($city)){
            $this->nav_title = '绑卡';
            $this->message = '绑卡失败，请选所在市';
            return $this->render('bank_message');
        }

        if(empty($branch)){
            $this->nav_title = '绑卡';
            $this->message = '绑卡失败，请填写开户行';
            return $this->render('bank_message');
        }

        if($account!=$confirm_account){
            $this->nav_title = '绑卡';
            $this->message = '绑卡失败，银行卡号填写不一致';
            return $this->render('bank_message');
        }


        $result = WebService::clientSoap(array('module'=>'account',
            'q'=>'add_user_bank',
            'method'=>'post',
            'account'=>$_POST['account'],
            'bank'=>$_POST['bank'],
            'province'=>$_POST['province'],
            'city'=>$_POST['city'],
            'branch'=>$_POST['branch'],
            'user_id'=>Yii::$app->user->id),Yii::$app->params['clientType']);

        if($result['result'] == 'success'){
            $this->nav_title = '绑卡';
            $this->message = '绑卡成功';
            return $this->render('bank_message');
        }else{
            $this->nav_title = '绑卡';
            $this->message = $result['error_remark'];
            return $this->render('bank_message');
        }


    }


    /*
     *获取地区
     */
    public function actionGetAreas(){
        $ar = (new AreasHelper())->getAreas();
    }

}
