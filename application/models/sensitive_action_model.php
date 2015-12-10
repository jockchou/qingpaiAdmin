<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sensitive_action_model extends CI_Model {
	public $db;
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function getSensitiveActionList($userID, $type, $state, $pageNo=1, $pageSize=20) {

		if ($userID != 0) {
			$condition = "b.userID = {$userID}";
		} else {
			$condition = "1=1";
		}

		if ($state !== FALSE && $state !== '') {
			$condition .= " AND b.state = {$state}";
		}

		if ($type !== FALSE && $type !== '') {
			$condition .= " AND b.type = {$type}";
		}

		$sql = "SELECT a.*, b.id AS sensitiveID, b.state AS sensitiveState, b.addTime, b.content, b.userID, b.targetUserID, b.type, b.checkTime FROM user a, sensitive_action b WHERE b.userID = a.id AND $condition ORDER BY b.id DESC";

		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql = $sql . $limit;

		$sql2 = "SELECT count(b.id) AS totalNum FROM user a, sensitive_action b WHERE b.userID = a.id AND $condition";

		$query2 = $this->db->query($sql2);

		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['userList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['userList'] = $query1->result_array();
		}
		
		return $data;
	}

	public function updateSensitiveActionState($userID, $type, $actionFrom) {

		if ($actionFrom == 'fenghao') {
			$whereArr = array(
				'userID' => $userID,
			);
		} else {
			$whereArr = array(
				'userID' => $userID,
				'type' => $type
			);
		}
			
		return $this->db->update('sensitive_action', array("state" => 1), $whereArr);
	}
	
	
}