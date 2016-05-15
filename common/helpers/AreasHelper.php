<?php

namespace common\helpers;
use Yii;
use common\helpers\WebService;

class AreasHelper{

    public function getAreas($clientType='wap'){
        $order = !empty($_REQUEST['order']) ? addcslashes($_REQUEST['order']) : "order";
        if (isset($_REQUEST['area_id'])){
            $_REQUEST["area_id"] = preg_replace("/[^\d]/i",'',$_REQUEST["area_id"]);
            $city = $_REQUEST["area_id"];
           // $result = dy_get_server(array('module' => 'areas','q' => 'get_list','limit'=>'all','pid'=>$city,'order'=>$order,'method'=>'get'));
            $user_result = array (
                "module" => "areas",
                "q" => "get_list",
                "limit" =>'all',
                "pid" =>$city,
                "order" =>$order,
                "method" => "get"
            );
            $result =   WebService::clientSoap($user_result,$clientType);

            $category['id'] = "";
            $category['name'] = $this->gbk2utf8("请选择");
            $categorys[0] = $category;
            if ($result['list']!=false){
                foreach ($result['list'] as $key => $row){
                    $category = array();
                    $category['id'] = $row['id'];
                    $category['name'] = $this->gbk2utf8($row['name']);
                    $categorys[$key+1] = $category;
                }
            }
            $json = json_encode($categorys);
            echo $json;
            exit;
        }

        if (isset($_REQUEST['value'])){
            $_REQUEST['area'] = $_REQUEST['value'];
        }

        $name = isset($_REQUEST['name'])?$_REQUEST['name']:"";

        $type = !isset($_REQUEST['type'])?"":$_REQUEST['type'];
        $class = !isset($_REQUEST['class'])?"":$_REQUEST['class'];

        if($type!=""){
            $_type = explode(",",$type);
        }else{
            $_type= array("p","c","a");
        }


        $province_id ="";
        $city_id = "";
        $area_id = "";
        if (isset($_REQUEST['area'])  && $_REQUEST['area']!=""){
            $_REQUEST["area"] = preg_replace("/[^\d]/i",'',$_REQUEST["area"]);
            $id = $_REQUEST['area'];

            $user_result1 = array (
                "module" => "areas",
                "q" => "get_one",
                "id" =>$id,
                "method" => "get"
            );
            $result1 =   WebService::clientSoap($user_result1,$clientType);
            //$result1 = dy_get_server(array('module' => 'areas','q' => 'get_one','id'=>$id,'method'=>'get'));


            if ($result1=="") $result1['pid'] =0;
            if ($result1['pid']==0){
                $province_id = $id;
            }else{
                //$result2 = dy_get_server(array('module' => 'areas','q' => 'get_one','id'=>$result1['pid'],'method'=>'get'));
                $user_result2 = array (
                    "module" => "areas",
                    "q" => "get_one",
                    "id" =>$result1['pid'],
                    "method" => "get"
                );
                $result2 =   WebService::clientSoap($user_result2,$clientType);

                if ($result2['pid']==0){
                    $province_id = $result1['pid'];
                    $city_id = $id;
                }else{
                    $province_id = $result2['pid'];
                    $city_id = $result1['pid'];
                    $area_id = $id;
                }
            }
        }

        $_city = "";
        if ($province_id!=""){
           // $city_res = dy_get_server(array('module' => 'areas','q' => 'get_city_list','province'=>$province_id,'method'=>'get','limit'=>'all','order'=>$order));
            $user_result3 = array (
                "module" => "areas",
                "q" => "get_city_list",
                "province" =>$province_id,
                "order" =>$order,
                "limit" =>'all',
                "method" => "get"
            );
            $city_res =   WebService::clientSoap($user_result3,$clientType);

            foreach ($city_res['list'] as $key => $value){
                $sel = "";
                if ($value['id'] === $city_id){ $sel = "selected";}
                $_city .= "<option value=".$value['id']." $sel>".$value['name']."</option>";
            }
        }

        $_area = "";
        if ($city_id!=""){

            //$area_res = dy_get_server(array('module' => 'areas','q' => 'get_area_list','city'=>$city_id,'method'=>'get','limit'=>'all','order'=>$order));
            $user_result4 = array (
                "module" => "areas",
                "q" => "get_area_list",
                "city" =>$city_id,
                "order" =>$order,
                "limit" =>'all',
                "method" => "get"
            );
            $area_res =   WebService::clientSoap($user_result4,$clientType);

            foreach ($area_res['list'] as $key => $value){
                $sel = "";
                if ($value['id'] === $area_id){ $sel = "selected";}
                $_area .= "<option value=".$value['id']." $sel>".$value['name']."</option>";
            }
        }


        //$result = dy_get_server(array('module' => 'areas','q' => 'get_province_list','method'=>'get','limit'=>'all','order'=>$order));

        $user_result5 = array (
            "module" => "areas",
            "q" => "get_province_list",
            "order" =>$order,
            "limit" =>'all',
            "method" => "get"
        );
        $result =   WebService::clientSoap($user_result5,$clientType);

        $_province ="";

        foreach ($result['list'] as $key => $value){
            $sel = "";
            if ($value['id'] === $province_id){ $sel = "selected";}
            $_province .= "<option value=".$value['id']." $sel>".$value['name']."</option>";
        }

        //js 部分

echo <<<Eof

$(document).ready(function (){
	$("#{$name}province").change(function(){

		var province = $(this).val();
		var count = 0;
		$.ajax({
			url:"/bank/get-areas",
			dataType:'json',
			data:"q=areas&area_id="+province,
			success:function(json){
				$("#{$name}city option").each(function(){
					$(this).remove();
				});
				$("#{$name}area option").each(function(){
					$(this).remove();
					$("<option value=''>请选择</option>").appendTo("#{$name}area");
				});
				$(json).each(function(){
					$("<option value='"+json[count].id+"'>"+json[count].name+"</option>").appendTo("#{$name}city");
					count++;
				});

			}
		});
	});
	$("#{$name}city").change(function(){
		var province = $(this).val();
		var count = 0;
		$.ajax({
            type:"GET",
			url:"/bank/get-areas",
			dataType:'json',
			data:"q=areas&area_id="+province,
			success:function(json){
				$("#{$name}area option").each(function(){
					$(this).remove();
				});
				$(json).each(function(){
					$("<option value='"+json[count].id+"'>"+json[count].name+"</option>").appendTo("#{$name}area");
					count++;
				});
				if(count>0)
				{
					$("#{$name}area").show();
				}else
				{
					$("#{$name}area").hide();
				}
			}
		});
	});
	$("#{$name}area").change(function(){

	});
});
Eof;


        $p = "<select id='{$name}province' name='{$name}province' class='{$class}'><option value=''>请选择</option>{$_province}</select>&nbsp;";
        $c = "<select id='{$name}city' name='{$name}city' class='{$class}'><option value=''>请选择</option>{$_city}</select>&nbsp;";
        $a = "<select id='{$name}area' name='{$name}area' class='{$class}'><option value=''>请选择</option>{$_area}</select>&nbsp;";
        $display= "";
        foreach ($_type as $key => $value){
            $display .= $$value;
        }

echo <<<Eof
document.write("{$display}");
Eof;

}

public  function gbk2utf8($str){
    return $str;
}


}