<?php
namespace wap\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\helpers\WebService;
use common\helpers\RequestHelper;
use \yii\base\Exception;
use \common\log\LogUtil;


/**
 * Site controller
 */
class SiteController extends Controller
{
    private $epage = 10;//每页显示条数
    public $layout = false;


    //获取首页推荐项目 todo
    public function actionIndex()
    {

        return $this->render('index');
    }

    /*
     * 标的列表页
     */
    public function actionDealList(){
        $page = RequestHelper::getInt('page') ? RequestHelper::getInt('page') : 1;
        $deal = array(
            'module'=>'borrow'
            ,'q'=>'get_list'
            ,'method'=>'get'
            ,'account_status'=>''
            ,'spread_month'=>''
            ,'keywords'=>''
            ,'epage'=>$this->epage
            ,'order'=>''
            ,'borrow_type'=>''
            ,'borrow_interestrate'=>''
            ,'status_nid'=>'invest'
            ,'query_type'=>'invest'
            ,'page'=>$page
        );
        $list = WebService::clientSoap($deal,Yii::$app->params['clientType']);

        //根据项目进度划圆圈

        if(is_array($list['list']) && !empty($list['list'])){
            foreach($list['list'] as $key=>$val){
                //圆圈初始化
                $leftcircle = 0;
                $rightcircle = 0;
                if(50 >= $val['borrow_account_scale'] && $val['borrow_account_scale']>0){
                    $rightcircle = 3.6*$val['borrow_account_scale'];
                }else if(50 < $val['borrow_account_scale'] && $val['borrow_account_scale']<=100){
                    $rightcircle = 180;
                    $leftcircle = ($val['borrow_account_scale']-50)*3.6;
                }
                $list['list'][$key]['leftcircle'] = $leftcircle;
                $list['list'][$key]['rightcircle'] = $rightcircle;
            }
        }

        return $this->render('list',[
            'list'=>$list['list'],
        ]);
    }


}
