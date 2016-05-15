<?php

namespace common\log;

use Yii;

use common\chinapnr\ChinapnrSDK;

use common\models\loginfo\LoginfoHuifu;
use common\models\loginfo\LoginfoRuning;

use common\models\user\UserHuifu;


/**
 * Description of LogUtil
 *
 * @author Administrator
 */
class LogUtil {

    public static function log($data, $logFilename = null) {
        $tmp = '参数空值';
        if ($data) {
            if (is_array($data)) {
                $tmp = '';
                foreach ($data as $k => $v) {
                    $tmp .= '[' . $k . ']=>' . (is_array($v) ? json_encode($v) : $v) . ',';
                }
            } else {
                $tmp = trim($data);
            }
        }

        $_filename = 'wcg_runing_' . date('Y-m-d', time()) . '.txt';
        if ($logFilename) {
            $_filename = $logFilename . '_' . date('Y-m-d', time()) . '.txt';
        }

        $_filename = Yii::getAlias('@runtime'). '/logs/' . $_filename;
        $add_time = date('Y-m-d H:i:s');
        $fp = fopen($_filename, "a+");
        fputs($fp, $tmp . "|$add_time|" . "\r\n");
        fclose($fp);
    }



    
}