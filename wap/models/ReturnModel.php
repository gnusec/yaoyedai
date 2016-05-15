<?php
namespace wap\models;
class ReturnModel {
	public $code;
	public $status;
	public $message;
	
	public $data;
	
	public function __construct() {
		$this->code=0;
		$this->status='success';
		$this->message='成功';
		$this->data = new ReturnDataModel();
	}
	
	public function initFail($fail_message,$code=1,$status='fail'){
		$this->code=$code;
		$this->status=$status;
		$this->message=$fail_message;
		$this->data=null;
	}
}