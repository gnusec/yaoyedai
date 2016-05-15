<?php

namespace common\helpers\identity;



interface smsInterface
{
    //发送短信抽象接口，不同短信渠道严格实现
    public  function sendsms($id,$ext);

    public  function sendemail();


}
