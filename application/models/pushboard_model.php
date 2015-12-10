<?php 

class Pushboard_model extends CI_Model{
		
	private $db;

	public function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getPushList($isSend="", $pageSize=10, $pageNo=1) {
	
		$sql = "select * from message_push";
		
		$where = ' WHERE 1 = 1';
		
		if ($isSend == "0" OR $isSend == "1" OR  $isSend == "2") {
			$where .= " AND isSend = $isSend";
		}
		
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM message_push " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['pushList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['pushList'] = $query1->result_array();
		}
		
		return $data;
	}
		
	public function savePush($data) {
		return $this->db->insert('message_push', $data);
	}
	
	public function delPush($id) {
		return $this->db->delete('message_push', array('id' => $id)); 
	}
}