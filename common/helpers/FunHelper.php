<?php

namespace common\helpers;
use Yii;

class FunHelper
{
   static function post_var($var,$type=""){
        if (is_array ( $var )) {
            foreach ( $var as $key => $val ) {
                $_val = isset ( $_POST [$val] ) ? $_POST [$val] : '';
                if ($_val == '') {
                    $_val = null;
                } elseif (is_array ( $_val )) {
                    $_val = join ( ',', $_val );
                }
                $_val = self::filterSqlInject($_val);
                $result [$val] = $_val;
            }
            return $result;
        } else {
            $_str = isset ( $_POST [$var] ) ?  self::filterSqlInject($_POST [$var]) : null;
            return $_str;
        }
    }

    static function filterSqlInject($_str){
        $_str = strip_tags($_str);
        $_str = str_replace("'", '&#39;', $_str);
        $_str = str_replace("\"", '&quot;', $_str);
        //把2个以上的减号替换成全角的
        if(preg_match("/-{2,}/i",$_str)){
            $_str = str_replace('-', '—', $_str);
        }
        $_str = str_replace("\\", '', $_str);
        $_str = str_replace("\/", '', $_str);
        $_str = str_replace("+/v", '', $_str);
        $clean = '';
        $error = '';
        $old_pos = 0;
        $pos = - 1;
        while ( true ) {
            $pos = strpos ( $_str, '\'', $pos + 1 );
            if ($pos === false) break;
            $clean .= substr ( $_str, $old_pos, $pos - $old_pos );
            while ( true ) {
                $pos1 = strpos ( $_str, '\'', $pos + 1 );
                $pos2 = strpos ( $_str, '\\', $pos + 1 );
                if ($pos1 === false) break;
                elseif ($pos2 == false || $pos2 > $pos1) {
                    $pos = $pos1;
                    break;
                }
                $pos = $pos2 + 1;
            }
            $clean .= '$s$';
            $old_pos = $pos + 1;
        }
        $clean .= substr($_str, $old_pos);
        $clean = trim(strtolower(preg_replace(array('~\s+~s' ), array(' '), $clean)));
        // 常用的程序里也不使用union，但是一些黑客使用它，所以检查它
        if (strpos ( $clean, ' union ' ) !== false && preg_match ( '~(^|[^a-z])union($|[^[a-z])~s', $clean ) != 0) {
            return false;
        } elseif (strpos ( $clean, '/*' ) > 2 ) {
            return false;
        } elseif (strpos ( $clean, ' sleep' ) !== false && preg_match ( '~(^|[^a-z])sleep($|[^[a-z])~s', $clean ) != 0) {
            return false;
        } elseif (strpos ( $clean, 'benchmark' ) !== false && preg_match ( '~(^|[^a-z])benchmark($|[^[a-z])~s', $clean ) != 0) {
            return false;
        } elseif (strpos ( $clean, 'load_file' ) !== false && preg_match ( '~(^|[^a-z])load_file($|[^[a-z])~s', $clean ) != 0) {
            return false;
        } elseif (strpos ( $clean, 'into outfile' ) !== false && preg_match ( '~(^|[^a-z])into\s+outfile($|[^[a-z])~s', $clean ) != 0) {
            return false;
        } elseif (preg_match ( '~\([^)]*?select~s', $clean ) != 0) {
            return false;
        }
        return $_str;
    }
}