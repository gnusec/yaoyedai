<?php
namespace common\models\user;

use common\services\login\UserService;
use Yii;
use yii\base\Model;
use common\models\user\Diyouuser;


/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $verify;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password','verify'], 'required'],
            ['password', 'validatePassword'],
            ['verify', 'captcha','captchaAction'=>'login/captcha'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {

        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || $user->password != md5($this->password)) {
                $this->addError($attribute, '用户名或者密码错误');
            }
       }
    }

//    public function validateVerify($attribute, $params)
//    {
//
//        if (!$this->hasErrors()) {
//            if(!isset($_SESSION['verify']) || $_SESSION['verify'] == '' || $_SESSION['verify'] != $this->verifyCode){
//                $this->addError($attribute, '验证码错误');
//            }
//        }
//    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */

    public function login()
    {
        $user = $this->getUser();
        return UserService::login($user);
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
              $this->_user = Diyouuser::findByName($this->username);
        }

        return $this->_user;
    }
}
