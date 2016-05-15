<?php
namespace wap\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\WebService;
use common\helpers\RequestHelper;

/**
 * Site controller
 */
class TraderecordController extends \wap\controllers\BaseLoginController
{
    public $layout = false;
    private $limit = 10;
    //ajax提交主要要设置个属性否则post提交失败 todo

    /*
     * 交易记录首页
     */
    public function actionIndex()
    {
        //交易列表
       // {list module="account" function="get_log_list" var=loop user_id=$_G.user_id epage=10 page=$smarty.request.page+1 account_type=$smarty.request.account_type  dotime1=$smarty.request.dotime1  dotime2=$smarty.request.dotime2 }
        $open['module']	= 'account';
        $open['q']		= 'get_log_list';
        $open ['user_id'] = Yii::$app->user->id;
        $open ['epage'] = $this->limit;
        $open ['page'] = 1;
     //   $open ['account_type'] = 0;
        $open['method']	= 'post';
        $openresult =  WebService::clientSoap($open,Yii::$app->params['clientType']);
//        echo "<pre>";
//        var_dump($openresult['list']) ;exit;
        //处理类型
//        if(!empty($openresult['list'])){
//            foreach($openresult['list'] as $key=>$val){
//
//            }
//        }
        return $this->render('trade_record',[
            'list'=>$openresult['list'],
        ]);
    }

    /*
     * 交易详情
     */

    public function actionView(){

        return $this->render('trade_detail');
    }

    /*
     * 投资记录
     */

    public function actionDealRecord(){

        //投资中
        $tender['module']	= 'borrow';
        $tender['q']		= 'get_tender_list';
        $tender['user_id'] =Yii::$app->user->id;
        $tender['status_type'] = 'tender';//投资状态
        $tender['page'] = 1;
        $tender['epage'] = $this->limit;
        $tender['method']	= 'get';
        $tenderresult =  WebService::clientSoap($tender,Yii::$app->params['clientType']);

        //还款中
        $recover['module']	= 'borrow';
        $recover['q']		= 'get_tender_list';
        $recover['user_id'] =Yii::$app->user->id;;
        $recover['status_type'] = 'recover';//投资状态
        $recover['page'] = 1;
        $recover['epage'] = $this->limit;
        $recover['method']	= 'get';
        $recoverresult =  WebService::clientSoap($recover,Yii::$app->params['clientType']);

        //已还款
        $end['module']	= 'borrow';
        $end['q']		= 'get_tender_list';
        $end['user_id'] =Yii::$app->user->id;;
        $end['status_type'] = 'end';//投资状态
        $end['page'] = 1;
        $end['epage'] = $this->limit;
        $end['method']	= 'get';
        $endresult =  WebService::clientSoap($end,Yii::$app->params['clientType']);
        //var_dump($recoverresult);exit;

        return $this->render('deal_record',[
           'tenderlist'=>$tenderresult['list'],
           'recoverlist'=>$recoverresult['list'],
           'endlist'=>$endresult['list'],
        ]);

    }


}
