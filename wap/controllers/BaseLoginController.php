<?php

namespace wap\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\helpers\WebService;
use yii\helpers\Url;

class BaseLoginController extends Controller
{

    public $nav_title;
    public $message;
//    public function init() {
//        parent::init();
//        session_start();
//        $this->isLogin();
//
//    }
    
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'allow'=>true,
//                        'roles'=>['@']
//                    ],
//                ],
//            ],
//        ];
//    }


    public function beforeAction($action)
    {
        $session = Yii::$app->session;
        if (Yii::$app->user->isGuest ) {
            return $this->redirect(Url::toRoute('/login'));
        }

        return parent::beforeAction($action);
    }



}