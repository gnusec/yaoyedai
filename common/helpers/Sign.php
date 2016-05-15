<?php

namespace common\helpers;
use Yii;

class Sign {
   static  function ParaFilter($parameter) {
        $para = array();
        foreach ($parameter as $key => $val) {
            if ($key != "sign" && $key != "method" && $val != "") {
                $para[$key] = $val;
            }
        }
        return $para;
    }
   static   function GetSign($parameter,$key) {
        if(isset($parameter['sign'])){
            unset($parameter['sign']);
        }
       
        $_parameter = array();
        $_parameter['diyou'] = $parameter['diyou'];
        unset($parameter['diyou']);
        $_parameter+=$parameter;
        $parameter = json_encode($_parameter,true);
        //AES 128位加密  wqs  14/7/9
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
 
        $parameter = self::pkcs5_pad($parameter, $size);
         
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
         
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
         
        mcrypt_generic_init($td, $key, $iv);
         
        $data = mcrypt_generic($td, $parameter);
        
        mcrypt_generic_deinit($td);
        
        mcrypt_module_close($td);
         
        $data = base64_encode($data);
        
        return $data;
    }
    static  function GetData($sStr, $sKey) {
     
       $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
     
       $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND); 
      
       $decrypted= @mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $sKey, base64_decode($sStr), MCRYPT_MODE_ECB, $iv);
     
       $dec_s = strlen($decrypted);
     
       $padding = ord($decrypted[$dec_s-1]);
     
       $decrypted = substr($decrypted, 0, -$padding);
     
       return $decrypted;
     
    }
   static  function pkcs5_pad ($text, $blocksize) {
 
        $pad = $blocksize - (strlen($text) % $blocksize);
 
        return $text . str_repeat(chr($pad), $pad);
 
    }
    static  function isSign($parameter, $sign) {
        global $diyou_auth;
        if (self::GetSign($parameter,$diyou_auth['dyauth']['diyou_key'][$parameter['diyou']['diyou_name']]) == $sign) {
            return true;
        } else {
            return false;
        }
    }

    //加密解密函数
    static function StrCrypt($string, $action = 'ENCODE')
    {
        $action != 'ENCODE' && $string = base64_decode($string);
        $code = '';
        $key = 'abcdefghijklmnopqrstuvwxyz';
        $keyLen = strlen($key);
        $strLen = strlen($string);
        for ($i = 0; $i < $strLen; $i++) {
            $k = $i % $keyLen;
            $code .= $string[$i] ^ $key[$k];
        }
        return ($action != 'DECODE' ? base64_encode($code) : $code);
    }

} ?>
