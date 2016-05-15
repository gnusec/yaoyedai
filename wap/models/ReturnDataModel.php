<?php
namespace wap\models;
class ReturnDataModel {
	public $result;
	public $msg;
	public $code;
	public $content;

	public function __construct() {
        $this->code = 0;
		$this->result = 'success';
		$this->msg = '成功';
		$this->content = null;
	}
	
	public function setContent($value){
		$this->content = $value; //$this->encryption->encrypt(json_encode($value));
	}
	
	public function getContent(){
		return $this->content;
	}
	
	public function initFail($fail_message,$code=-1,$result='fail'){
        $this->code = $code;
		$this->result=$result;
		$this->msg=$fail_message;
		$this->content=null;
	}
}