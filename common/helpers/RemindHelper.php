<?php

namespace common\helpers;
use Yii;
use common\helpers\DefaultSmsPort;

class RemindHelper{

    private static  $indentity = null;
    const SMSPORT_DEFAULT  = 'DefaultSmsPort';

    private function __construct($indentity) {

    }

    //构造不同的短信对象
    public static function getSmsIndentity($indentity) {
        if (!(self::$indentity instanceof self)) {
           // $d = constant(__CLASS__ . "::SMSPORT_" . $indentity);
            self::$indentity  = new   DefaultSmsPort();
          //  self::$indentity = new self($indentity);
        }
        return self::$indentity;
    }

    public function actionHd(){
        echo 'ddddd';exit;
    }


}