<?php

namespace wap\modules\users\controllers;
use Yii;
use yii\web\Controller;
use common\wechat\Wechat;
use common\helpers\WebService;
use common\models\queue\QueueLog;
use common\models\spreads\FriendsInvite;

class InvitefriendController extends \wap\controllers\BaseLoginController
{
    public $enableCsrfValidation = false;
    public $layout = false;

    /*
     * 邀请好友首页
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    /*
     *邀请活动页面
     */

    public function actionShareActive(){
        //微信分享
        $JSSDK = new Wechat();
        $signPackage = $JSSDK->getJsSignature();
        $ret['signPackage'] = $signPackage;
        $ret['user_id'] = Yii::$app->user->id;
        $ret['shareurl'] = rtrim(Yii::$app->params['clientUrl']['wap'],'/').'/register?inviteid='.Yii::$app->user->id;
        return $this->render('shareactive',$ret);
    }
    /*
     * 查看邀请好友总人数
     */

    public function actionViewFriendNums(){
        //奖励列表
        $list = (new QueueLog())->getFriendList();
        //邀请好友个数
        $inviterNums = FriendsInvite::find()->where('user_id='.Yii::$app->user->id)->count();
        //一级奖励个数
        $oneLevelNums = QueueLog::Level('one_level');
        //二级奖励个数
        $twoLevelNums = QueueLog::Level('two_level');

        return $this->render('invitefriend',[
            'list'=>$list->list,
            'pagination' => $list->pagination,
            'begin_time' => $list->begin_time,
            'end_time' => $list->end_time,
            'inviternums'=>$inviterNums,
            'oneLevelNums'=>$oneLevelNums,
            'twoLevelNums'=>$twoLevelNums,
        ]);
    }



    /*
     * 查看好友投资金额
     */
    public function actionViewFriendMoney(){
        $list = (new QueueLog())->getFriendDeal();
        return $this->render('invitefrienddeal',[
            'list'=>$list->list,
            'pagination' => $list->pagination,
        ]);
    }

}
