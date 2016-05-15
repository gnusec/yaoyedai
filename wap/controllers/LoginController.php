<?php
namespace wap\controllers;

use Yii;
use yii\web\Controller;
use common\log\LogUtil;
use common\helpers\RequestHelper;
use common\models\user\LoginForm;
use yii\captcha\CaptchaValidator;
use yii\helpers\Url;
class LoginController extends Controller
{

    public $layout = 'auth';

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'height' => 30,
                'width' => 75,
                'minLength' => 4,
                'maxLength' => 4,
                'testLimit' => 2,
                'offset' => 2,
            ],
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->user->isGuest){
            //return $this->redirect('/users/user');
            return $this->redirect(Url::toRoute('/users/user'));
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->login()) {
            //return $this->goBack();
            return $this->redirect(Url::toRoute('/users/user'));
            //return $this->redirect('/users/user');
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    //退出
    public function actionLogout()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        } else {
            Yii::$app->user->logout();
            return $this->goHome();
        }
    }


}
