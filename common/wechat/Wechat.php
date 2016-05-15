<?php

namespace common\wechat;

use Yii;
use common\wechat\WechatSDK;
use common\wechat\ErrorCode;

class Wechat extends WechatSDK {

    public $token;
    public $encodingAesKey;
    public $appid;
    public $appsecret;
    public $debug;
    public $logcallback;

    private $cacheFile;
    private $logFile;

    public function __construct() {
        $this->cacheFile = rtrim(Yii::$app->getRuntimePath(),'/').'/WechatCache.json';
        $this->logFile = rtrim(Yii::$app->getRuntimePath(),'/').'/WechatLog.log';
        $wechatConfig = Yii::$app->params['wechat'];
        $this->appid = $wechatConfig['appid'];
        $this->encodingAesKey = $wechatConfig['encodingAesKey'];
        $this->appsecret = $wechatConfig['appsecret'];
        $this->token = $wechatConfig['token'];
        $this->debug = $wechatConfig['debug'];
        $this->logcallback = $wechatConfig['logcallback'];
    }

    protected function log($log) {
        file_put_contents($this->logFile,$log.' |'.date('Y-m-d H:i:s'),FILE_APPEND);
        return true;
    }

    /**
     * 重载设置缓存
     * @param string $cachename
     * @param mixed $value
     * @param int $expired
     * @return boolean
     */
    protected function setCache($cachename, $value, $expired) {
        $cache = [];
        if(file_exists($this->cacheFile)){
            $cache = (Array)json_decode(file_get_contents($this->cacheFile),true);
            $cache[$cachename]['value'] = $value;
            $cache[$cachename]['expire'] = time() + intval($expired);
            file_put_contents($this->cacheFile,json_encode($cache));
            return true;
        }else{
            $cache[$cachename]['value'] = $value;
            $cache[$cachename]['expire'] = time() + intval($expired);
            file_put_contents($this->cacheFile,json_encode($cache));
            return true;
        }
    }

    /**
     * 重载获取缓存
     * @param string $cachename
     * @return mixed
     */
    protected function getCache($cachename) {
        if(file_exists($this->cacheFile)){
            $cache = (Array)json_decode(file_get_contents($this->cacheFile),true);
            if(!isset($cache[$cachename]) || time() > intval($cache[$cachename]['expire'])){
                return false;
            }
            return $cache[$cachename]['value'];
        }else{
            return false;
        }
    }

    /**
     * 重载清除缓存
     * @param string $cachename
     * @return boolean
     */
    protected function removeCache($cachename) {
        if(file_exists($this->cacheFile)){
            $cache = (Array)json_decode(file_get_contents($this->cacheFile),true);
            if(!isset($cache[$cachename]) || time() > intval($cache[$cachename]['expire'])){
                return true;
            }
            unset($cache[$cachename]);
            return true;
        }else{
            return true;
        }
    }
    
    public static function IsWechatBower(){
        //return true;
        $userAgent = isset($_SERVER['HTTP_USER_AGENT'])?strtolower($_SERVER['HTTP_USER_AGENT']):'';
        if(stristr($userAgent,'micromessenger') !== false){
            return true;
        }
        return false;
    }

    public function getJsSignature($timestamp = 0, $noncestr = '', $appid = ''){
        $url = Yii::$app->request->hostInfo.Yii::$app->request->getUrl();
        return $this->getJsSign($url, $timestamp, $noncestr, $appid);
    }

}
