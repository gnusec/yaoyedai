<?php

namespace common\services\login;

use Yii;
use Exception;
use yii\helpers\ArrayHelper;
use common\models\user\Diyouuser;

class UserService
{
    public static function login(Diyouuser $user)
    {
        try {
             return Yii::$app->user->login($user);
        } catch (Exception $e) {
            return ['code' => $e->getCode(), 'message' => $e->getMessage()];
        }
    }
}