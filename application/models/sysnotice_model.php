<?php
class SysNotice_Model extends CI_Model {
	private $db;
	
	function __construct() {
		parent::__construct();
		$this->db = $this->load->database('default', TRUE);
	}
	
	public function getSysNoticeList($type, $pageSize=10, $pageNo=1) {
		$sql = 'SELECT * FROM sys_notice';
		
		$where = ' WHERE 1 = 1';
		
		if($type){
			$where .= " AND type = $type";
		}
		
		$start = ($pageNo - 1) * $pageSize;
		$orderBY = " ORDER BY id DESC";
		$limit = " LIMIT $start, $pageSize";
		
		$sql .= ($where . $orderBY . $limit);
		
		$sql2 = "SELECT count(*) AS totalNum FROM sys_notice " . $where;
		
		$query2 = $this->db->query($sql2);
		$totalTmp = $query2->result_array();
		$totalNum = $totalTmp[0]['totalNum'];
		
		$data['totalPages'] = ceil($totalNum / $pageSize);
		$data['sysNoticeList'] = array();
		
		if ($totalNum > 0) {
			$query1 = $this->db->query($sql);
			$data['sysNoticeList'] = $query1->result_array();
		}
		
		return $data;
		
	}
	
	public function saveSysNotice($data) {
		return $this->db->insert('sys_notice', $data);
	}
	
	public function deleteSysNotice($id) {
		return $this->db->delete('sys_notice', array('id' => $id));
	}
	
}