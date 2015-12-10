<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jjuser_model extends CI_Model {
	public $db;
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getUserList($id=null, $nickname=null, $mobileNum=null, $openType=null, $state=null,$isDubious=null, $pageNo=1, $pageSize=10, $onlyRobots=false, $order=false, $isFamous = 2) {
		$sql = "SELECT * FROM user";
		$where = " WHERE 1 = 1";
		
		if ($onlyRobots) {
			$where .= " AND id < 100000 AND id != 10086";
		}
		if ($id != null && $id > 0) {
			$where .= ' AND id = ' . $id;
		} else {
			if (!empty($nickname)) {
				$where .= " AND nickname LIKE '$nickname%'";
			}
			
			if (!empty($mobileNum)) {
				$where .= " AND mobileNum LIKE '+86$mobileNum'";
			}

			if ($openType === "0" OR $openType === "1" OR $openType === "3") {
				$where .= ' AND openType = ' . $openType;
			}
			
			if ($state === "0" OR $state === "1") {
				$where .= ' AND state = ' . $state;
			}
			
			if ($isDubious === "0" OR $isDubious === "1") {
					$where .= ' AND isDubious = ' . $isDubious;
			}
			
			if ($isFamous == 1) {
				$where .= ' AND isFamous = ' . $isFamous;
			}
		}
		
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		
		if ($order == "desc") {
			$orderBY = " ORDER BY praiseCnt DESC";
		} else if ($order == 'asc') {
			$orderBY = " ORDER BY praiseCnt ASC";
		} else {
			$orderBY = " ORDER BY id DESC";
		}
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM user " . $where;
		
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
	
	public function getUserComplainList($userID, $nickname, $state, $isDubious, $pageNo=1, $pageSize=20) {

		if ($userID != 0) {
			$condition = "b.complainUserID = {$userID}";
		} else {
			$condition = "1=1";
		}

		//搜索昵称页数计算不了，会不准确
		if (!empty($nickname)) {
			$condition .= " AND a.nickname = '$nickname'";
		}

		if ($state !== FALSE) {
			$condition .= " AND a.state = {$state}";
		}

		if ($isDubious !== FALSE) {
			$condition .= " AND a.isDubious = {$isDubious}";
		}

		$sql = "SELECT a.*, b.id AS complainID, b.addTime, b.reason, b.userID, b.checkTime FROM user a, user_complain b WHERE b.complainUserID = a.id AND $condition ORDER BY b.id DESC";

		$start = ($pageNo - 1) * $pageSize;
		
		$limit = " LIMIT $start, $pageSize";
		
		$sql = $sql . $limit;

		$sql2 = "SELECT count(b.id) AS totalNum FROM user a, user_complain b WHERE b.complainUserID = a.id AND $condition";

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

	public function updateSensitiveActionState($userID, $type) {
		$whereArr = array(
			'userID' => $userID,
			'type' => $type,
		);
		return $this->db->update('sensitive_action', array("state" => 1), $whereArr);
	}
	
	public function unblockUser($userID) {
		$this->db->where('id', $userID);
		return $this->db->update('user', array("state" => "0"));
	}
	
	public function updateFamous($userID, $isFamous) {
		$this->db->where('id', $userID);
		return $this->db->update('user', array("isFamous" => $isFamous));
	}
	
	public function blockUser($userID) {
		$this->db->where('id', $userID);
		return $this->db->update('user', array("state" => "1"));
	}
	
	public function setDubious($userID) {
		$this->db->where('id', $userID);
		return $this->db->update('user', array("isDubious" => "1"));
	}
	public function removeDubious($userID){
		$this->db->where('id', $userID);
		return $this->db->update('user', array("isDubious" => "0"));
	}
	public function getUserState($userID){
		$sql = "select state,isDubious from user where id=?";
		$result = $this->db->query($sql, array($userID));
		return $result->row_array();
	}
	public function get_user_by_id($userID) {
		$query = $this->db->get_where('user', array('id' => $userID));
		return $query->row_array();
	}
	
	public function getUserByIdList($userIdList){
		if(empty($userIdList))return array();
		$userIdList = implode(",", $userIdList);
		$sql = "select * from user where id in({$userIdList})";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
		//获取用户关注列表
	public function getFollowList($userID, $cnt=10) {
		$sql = "SELECT a.*, b.userID, b.followUserID, b.followTime FROM user a LEFT JOIN user_follow b ON a.id = b.followUserID WHERE b.userID = ? ORDER BY b.id DESC LIMIT ?";
		$query = $this->db->query($sql, array($userID, $cnt));
		return $query->result_array();
	}
	
	public function getAllRobot() {
		$sql = "select * from user where id < 100000 and id != 10086";
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getUserLocation($pageNo=1, $pageSize=10) {
		$start = ($pageNo - 1) * $pageSize;
		$ttmp = date("Y-m-d H:i:s", strtotime("-1 day"));
		$select = "SELECT a.nickname, a.headUrl, a.sex, a.lastLoginTime, b.*";
		$from = " FROM user a INNER JOIN user_location b ON a.id = b.userID";
		$where = " WHERE b.updateTime >= '$ttmp'";
		$groupBy = " GROUP BY a.id "; 
		$orderBY = " ORDER BY b.updateTime DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql = $select . $from . $where . $groupBy . $orderBY . $limit;
		
		$sql2 = "SELECT COUNT(1) AS totalNum FROM (SELECT DISTINCT b.userID FROM user a INNER JOIN user_location b ON a.id = b.userID WHERE b.updateTime >= '$ttmp') AS t";
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['locationList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['locationList'] = $query1->result_array();
		}
		return $data;
	}
}

/* End of file jjuser_model.php */
/* Location: ./application/models/jjuser_model.php */