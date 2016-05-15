<?php

namespace common\helpers;
use Yii;
use common\helpers\Sign;

class WebService{
     private static  $link;
    /**
     * 构造函数
     */
//    private function __construct($data,$clientData,$serverType,$ext) {
//        return call_user_func_array([$this,'client'.$serverType],[$data,$clientData]);
//    }

//    static  function getWebService(array $data,array $clientData,$serverType,$ext=false){
//        if (!(self::$link instanceof self)) {
//            self::$link = new self($data,$clientData,$serverType,$ext);
//        }
//        return self::$link;
//    }
      //配置改到了common
     static    function clientSoap(array $data,$clientType){
         // $data= fliter_safe_deayou($data); todo

         $data['diyou'] = Yii::$app->params['yaoyedai'][$clientType];
         $data['ip_address'] = self::ip_address();
         $data['method'] = empty($data['method'])?'post':strtolower($data['method']);
         $data["sign"] = Sign::GetSign($data, Yii::$app->params['yaoyedai'][$clientType]["diyou_key"]);
         $data['diyou'] = base64_encode(json_encode($data['diyou']));
         try {
             $client = new \SoapClient(null, array('location' => Yii::$app->params['yaoyedai'][$clientType]['diyou_server'],'uri' =>  Yii::$app->params['yaoyedai'][$clientType]['diyou_server'],'encoding'=>'utf-8'));
             $data = json_encode($data);
             $result = $client->DiyouServerSoap($data);
             $client->decode_utf8 = true;
             $return =  json_decode($result,true);

             return $return;
         } catch (\SoapFault $fault){
             echo "Error: ",$fault->faultcode,", string: ",$fault->faultstring;
             exit;
         }
      }

     static    function ip_address($type = 0){
         try {
            if(!empty($_SERVER["HTTP_CLIENT_IP"]))
            {
                $ip_address = $_SERVER["HTTP_CLIENT_IP"];
            }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip_address = array_pop(explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']));
            }else if(!empty($_SERVER['REMOTE_ADDR'])){
                $ip_address = $_SERVER['REMOTE_ADDR'];
            }else{
                $ip_address = '';
            }
            $ip = array();
            preg_match('/\d+\.\d+\.\d+\.\d+/', $ip_address, $ip);
            if(!empty($ip[0])){
                $ip_address = $ip[0];
            }else{
                $ip_address = '';
            }
            return $ip_address;
         }catch(\Exception  $ex){
             $ip_address = '';
             return $ip_address;
         }
    }


 }