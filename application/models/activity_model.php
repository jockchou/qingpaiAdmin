<?php
class Activity_model extends CI_Model {
	public $db;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}

	public function saveActivity($data) {
		return $this->db->insert('oper_activity', $data);
	}

	public function getActivityList($pageNo = 1, $pageSize = 10) {
		
		$sql = "SELECT * FROM oper_activity";
		
		$where = " WHERE 1=1";
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM oper_activity" . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->row_array();
		$totalNum = $totalTmp['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['activityList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['activityList'] = $query1->result_object();
		}
		
		return $data;
	}

	public function deleteActivity($id) {
		return $this->db->delete('oper_activity', array('id' => $id)); 
	}

	public function offActivity($id, $onlineStatus) {
		$this->db->where('id', $id);
		return $this->db->update('oper_activity', array('onlineStatus' => $onlineStatus)); 
	}

}