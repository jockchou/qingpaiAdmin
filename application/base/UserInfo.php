<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserInfo {

	var $id = 0;
	var $openID = "";
	var $openType = 0;
	
	var $nickname = "";
	var $headUrl = "";
	var $sex = 0;
	var $birthday = "";
	
	var $signature = "";
	var $heatCnt = 0;
	var $praiseCnt = 0;
	var $mobileNum = "";
	
	var $regTime = '';
	var $lastLoginTime = '';
	var $state = 0;
	
	public function __construct($params) {
		$this->regTime = date('Y-m-d H:i:s');
		$this->lastLoginTime = date('Y-m-d H:i:s');
		
		if (count($params) > 0) {
			$this->initialize($params);
		}
	}
	
	//初始化
	function initialize($params = array()) {
		if (count($params) > 0) {
			foreach ($params as $key => $val) {
				if (isset($this->$key)) {
					$this->$key = $val;
				}
			}
		}
	}
	
	//获取协议中标准用户结构体
	function format() {
		return array(
			"userID" => (string)$this->id,
			"nickname" => (string)$this->nickname,
			"headUrl" => (string)$this->headUrl,
			"sex" => (int)$this->sex,
			"heat" => (int)$this->heatCnt,
			"praiseCnt" => (int)$this->praiseCnt,
			"birthday" => (string)$this->birthday,
			"signature" => (string)$this->signature,
			"onlineTime" => strtotime($this->lastLoginTime) . "000"
		);
	}
	
}