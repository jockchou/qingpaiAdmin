<?php
class Message_model extends CI_Model {
	public $db;
	public $msdb;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
		$this->msdb = $this->load->database('pingo_ms', TRUE);
	}
	
	
	public function getMessageList($isSend="", $pageSize=10, $pageNo=1) {
		$sql = "select * from message";
		
		$where = ' WHERE 1 = 1';
		
		if ($isSend == "0" OR $isSend == "1" OR  $isSend == "2") {
			$where .= " AND isSend = $isSend";
		}
		
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM message " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['messageList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['messageList'] = $query1->result_array();
		}
		
		return $data;
	}
	
	public function saveMessage($data) {
		return $this->db->insert('message', $data);
	}
	
	public function delMessage($id) {
		return $this->db->delete('message', array('id' => $id)); 
	}
	
	public function getChatContentList($userID, $rpUserID) {
		$tabelName = "msg_" . $userID % 1000;
		$startTime = JY_getMsTime() - 3*24*60*60*1000;
		
		$sql = "SELECT * FROM {$tabelName} WHERE mUid = ? AND mType = 1 AND mTime > {$startTime} AND mBody LIKE '%{$rpUserID}%' ORDER BY mId DESC LIMIT 50";
		
		$query = $this->msdb->query($sql, array($userID));
		return $query->result_array();
	}
	
	public function getNoticeList($mState = 0, $pageNo=1, $pageSize=50){
		
		$start = ($pageNo - 1) * $pageSize;
		
		$sql = "select fromUserID from msg where mState = $mState and mUid = 10086 and fromUserID != 0 and mType = 1 order by mId desc limit $start, $pageSize";
		
		$query = $this->msdb->query($sql);
		$fromUserIDList = $query->result_array();
		
		$userIDList = "";
		foreach ($fromUserIDList as $key => $idList){
			if($key != 0) $userIDList .= ",";
			$userIDList .= $idList['fromUserID'];
		}
		if($userIDList == "")return array();
		$select = "SELECT * FROM user ";
		$where = "WHERE id in ({$userIDList})";
		$sql = $select.$where;
		$query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getMessage($type, $toUserID){
		
		if($type == 0){
			$sql = "select mId,fromUserID,mBody,mTime from msg_86 where mState = 0 and mType = 1 and mUid = 10086 and fromUserID = $toUserID order by mTime desc";
			$query = $this->msdb->query($sql);
			return $query->result_array();
		}else{
			$sql = "select mId,fromUserID,mBody,mTime from msg where ";
			$sql .= "mUid = $toUserID and fromUserID = 10086 ";
			$sql .= "order by mTime asc";
			$query = $this->msdb->query($sql);
			$result1 = $query->result_array();
			$sql = "select mId,fromUserID,mBody,mTime from msg_86 where ";
			$sql .= "mUid = 10086 and fromUserID = $toUserID and fromUserID != 0 and mType = 1 ";
			$sql .= "order by mTime asc";
			$query = $this->msdb->query($sql);
			$result2 = $query->result_array();
			
			$msgArr = array();
			foreach ($result1 as $k1 => $v1){
				$msgArr[$v1['mTime']] = $v1;
			}
			
			foreach ($result2 as $k2 => $v2){
				$msgArr[$v2['mTime']] = $v2;
			}
			
			ksort($msgArr);
			
			return $msgArr;
		}
		
	}
	
	public function updateMsg($mIdList, $userID){
		if(empty($mIdList)) return ;
		$mIdList = implode(",", $mIdList);
		$sql = "update msg_86 set mState = 1 where fromUserID = $userID and mState = 0 and mType = 1 and mId in ({$mIdList})";
		return $this->msdb->query($sql);
	}
}