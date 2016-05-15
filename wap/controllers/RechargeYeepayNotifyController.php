<?php
namespace wap\controllers;

use Yii;
use yii\web\Controller;
use common\helpers\WebService;
use \yii\base\Exception;
use \common\log\LogUtil;

$RootPath = Yii::getAlias("@common").DIRECTORY_SEPARATOR.'yeepay'.DIRECTORY_SEPARATOR;
require_once($RootPath.'Crypt_Rijndael.php');
require_once($RootPath.'Crypt_AES.php');
require_once($RootPath.'Crypt_DES.php');
require_once($RootPath.'Crypt_Hash.php');
require_once($RootPath.'Crypt_RSA.php');
require_once($RootPath.'Crypt_TripleDES.php');
require_once($RootPath.'Math_BigInteger.php');

class RechargeYeepayNotifyController extends Controller{
    public $nav_title = '';
    public $message = '';
    public  $layout = false;
    public function actionIndex(){

     try{
        if(isset($_REQUEST['data']) && isset($_REQUEST['encryptkey'])){//判断易宝支付返回
            $data = $_REQUEST['data'];
            $encryptkey = $_REQUEST['encryptkey'];

            $RSA = new \Crypt_RSA();
            $RSA->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);
            $RSA->setSignatureMode(CRYPT_RSA_SIGNATURE_PKCS1);
            $AES = new \Crypt_AES(CRYPT_AES_MODE_ECB);
            //var_dump($AES);exit;
            //$result = dy_get_server(array('module'=>'account','q'=>'get_payment_one','nid' => 'yeepay'));

            $api['module'] = 'account';
            $api['q']		= 'get_payment_one';
            $api['nid']		= 'yeepay';
            $result = WebService::clientSoap($api,Yii::$app->params['clientType']);


            $merchantPrivateKey = $result['fields']['merchantPrivateKey']['value'];
            $yibaoPublickey = $result['fields']['yibaoPublickey']['value'];

            $RSA->loadKey($merchantPrivateKey);
            $yeepayAESKey = $RSA->decrypt(base64_decode($encryptkey));

            $AES->setKey($yeepayAESKey);
            /**长整型作为字符串**/
            $json = $AES->decrypt(base64_decode($data));
            $return =  preg_replace('/:(\d{11,})(\,|\})/', ':"$1"$2', $json);
            $return = json_decode($return,true);

            if(!array_key_exists('sign', $return)){
                if(array_key_exists('error_code', $return))
                    //echo "<script>location.href='resultresulterror'</script>";
                    $this->nav_title = '充值';
                    $this->message = '充值失败，验签失败！';
                    return $this->render('//recharge/recharge_err');
            }
            $check_arr = $return;
            $sign= $return['sign'];

            if(array_key_exists('sign', $check_arr))
                unset($check_arr['sign']);
            ksort($check_arr);
            $RSA->loadKey($yibaoPublickey);
            $sign_check = $RSA->verify(join('',$check_arr),base64_decode($sign));
            if(!$sign_check){
                //echo "<script>location.href='resultresulterror'</script>";
                $this->nav_title = '充值';
                $this->message = '充值失败，验证sign失败！';
                return $this->render('//recharge/recharge_err');
            }


            //dy_get_server(array('data'=>$data,'encryptkey'=>$encryptkey,'result'=>$result,'trade_no'=>$return['orderid'],'module'=>'account','q'=>'add_recharge_return','method'=>'post'));

            $reapi['module']    = 'account';
            $reapi['q']		     = 'add_recharge_return';
            $reapi['trade_no']  = $return['orderid'];
            $reapi['result']	 = $result;
            $reapi['encryptkey']= $encryptkey;
            $reapi['data']		 = $data;
            $reapi['method']	 = 'post';

            $result = WebService::clientSoap($reapi,Yii::$app->params['clientType']);

            //echo "医药贷充值成功！";
            //echo "<script>location.href='resultresultsuccess'</script>";
            $this->nav_title = '充值';
            $this->message = '充值成功';
            return $this->render('//recharge/recharge_err');
        }
     }catch(\Exception  $ex){
         LogUtil::log($ex->getMessage(),'realname_err');
         $this->nav_title = '充值';
         $this->message = '充值失败';
         return $this->render('//recharge/recharge_err');
     }

    }


}



